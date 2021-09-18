<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Sms_account;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use JoshuaChinemezu\SmsGlobal\RestApi\RestApiClient;

class SMSAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat()
    {
        return view('sms_accounts.chat', []);
    }

    /**
     * get email account by id for form edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllSMSAccount()
    {
        $sms_account = Sms_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        return response()->json($sms_account);
    }

    /**
     * get email account by id for form edit.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSMSAccount(int $id)
    {
        $sms_account = Sms_account::find($id);
        return response()->json(['sms_account' => $sms_account]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'name' => 'required|string|max:128',
            'username' => 'required|string|max:128',
            'pwd' => 'required|string|max:255',
        ]);

        $data['pwd'] = Crypt::encryptString($data['pwd']);

        $account_id = array('account_id' => Auth::user()->account_id);
        $data = array_merge($data,  $account_id);

        $start_date = array('start_date' => today());
        $data = array_merge($data,  $start_date);

        $sms_account = Sms_account::create($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sms_accounts.create', 'element' => getElementByName('sms_accounts'), 'element_id' => $sms_account->id, 'source' => 'sms_accounts.create']);

        $sms_accounts = Sms_account::where('status', 1)->get();
        $returnHTML = view('sms_accounts/datatable-sms_accounts', compact('sms_accounts'))->render();
        return response()->json(['success' => 'SMS Account Created', 'html' => $returnHTML, 'sms_account' => $sms_account]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sms_account  $sms_account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms_account $sms_account)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Sms_account,id',
            'name' => 'required|string|max:128',
            'username' => 'required|string|max:128',
        ]);

        if ($request->pwd && $request->validate(['pwd' => 'required|string|max:255'])) {
            $pwd = array('pwd' => Crypt::encryptString($request->pwd));
            $data = array_merge($data,  $pwd);
        }

        $account_id = array('account_id' => Auth::user()->account_id);
        $data = array_merge($data,  $account_id);

        $sms_account = Sms_account::find($request->id);
        $sms_account->update($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sms_accounts.update', 'element' => getElementByName('sms_accounts'), 'element_id' => $sms_account->id, 'source' => 'sms_accounts.update']);

        $sms_accounts = Sms_account::where('status', 1)->get();
        $returnHTML = view('sms_accounts/datatable-sms_accounts', compact('sms_accounts'))->render();
        return response()->json(['success' => 'Email Account Updated', 'html' => $returnHTML, 'sms_account' => $sms_account]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $sms_account = Sms_account::find($id);
        $sms_account->status = 0;
        $sms_account->end_date = today();
        if ($sms_account->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sms_accounts.delete', 'element' => getElementByName('sms_accounts'), 'element_id' => $id, 'source' => 'sms_accounts.delete, ' . $id]);

            $sms_accounts = Sms_account::where('status', 1)->get();
            $returnHTML = view('sms_accounts.datatable-sms_accounts', compact('sms_accounts'))->render();
            return response()->json(['success' => 'SMS Account Deleted !!!', 'html' => $returnHTML, 'sms_account' => $sms_account]);
        } else
            return response()->json(['error' => 'Failed to delete this SMS Account !!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'username' => 'required|exists:App\Models\Sms_account,username',
            'to' => 'required|string|max:128',
            'message' => 'required|string',
        ]);

        $sms_account = Sms_account::where('username', $request->username)->first()->get();

        $smsglobal = new RestApiClient();
        $smsglobal = $smsglobal->sendMessage([
            "destination" => $request->to, // Destination mobile number. 3-15 digits
            "message" => $request->message, // The SMS message. If longer than 160 characters (GSM) or 70 characters (Unicode), splits into multiple SMS
        ]); // Check https://www.smsglobal.com/rest-api/ for more options

        return response()->json(['success' => 'SMS Sent to ' . $data['to'], 'smsglobal' => $smsglobal]);
    }
}
