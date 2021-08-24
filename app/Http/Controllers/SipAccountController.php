<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Channel;
use App\Models\Log;
use App\Models\Sip_account;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SipAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sip_accounts = Sip_account::all();
        $accounts = Account::where('status', 1)->get();
        $channels = Channel::where('status', 1)->get();
        $logs = Log::all();
        $sip_account = $sip_accounts->first();
        return view('/sip_accounts/index', [
            'sip_accounts' => $sip_accounts,
            'sip_account' => $sip_account,
            'accounts' => $accounts,
            'channels' => $channels,
            'logs' => $logs,
        ]);
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
            'channel_id' => 'required|exists:App\Models\Channel,id',
            'host' => 'required|string|max:128',
            'port' => 'required|integer|digits_between:1,10',
            'username' => 'required|string|max:128',
            'pwd' => 'required|string|max:255',
            'name' => 'required|string|max:128',
            'priority' => 'required|integer|digits_between:1,1',
        ]);

        $data['pwd'] = Crypt::encryptString($request->pwd);

        $account_id = array('account_id' => Auth::user()->account_id);
        $data = array_merge($data,  $account_id);
        $start_date = array('start_date' => today());
        $data = array_merge($data,  $start_date);

        $sip_account = Sip_account::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sip_accounts.create', 'element' => getElementByName('sip_accounts'), 'element_id' => $sip_account->id, 'source' => 'sip_accounts.create']);
        
        $sip_accounts = Sip_account::all();
        $returnHTML = view('sip_accounts/list', compact('sip_accounts'))->render();
        
        $sip_accounts = Sip_account::where('status', 1)->get();
        $returnHTMLRedux = view('sip_accounts/list-redux', compact('sip_accounts'))->render();
        return response()->json(['success' => 'SIP Account Created', 'html' => $returnHTML, 'htmlRedux' => $returnHTMLRedux, 'sip_account' => $sip_account]);
    }

    /**
     * get sip account by id for form edit.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSipAccount(int $id)
    {
        $sip_account = Sip_account::find($id);
        $sip_account->pwd = Crypt::decryptString($sip_account->pwd);
        return response()->json(['sip_account' => $sip_account]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $sip_account = Sip_account::find($id);

        $returnHTML = view('sip_accounts/info', compact('sip_account'))->render();
        return response()->json(['success' => 'SIP Accounts found', 'html' => $returnHTML]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sip_account  $sip_account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sip_account $sip_account)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Sip_account,id',
            'channel_id' => 'required|exists:App\Models\Channel,id',
            'host' => 'required|string|max:128',
            'port' => 'required|integer|digits_between:1,10',
            'username' => 'required|string|max:128',
            'pwd' => 'required|string|max:255',
            'name' => 'required|string|max:128',
            'priority' => 'required|integer|digits_between:1,1',
        ]);

        if ($request->pwd && $request->validate(['pwd' => 'required|string|max:255'])) {
            $pwd = array('pwd' => Crypt::encryptString($request->pwd));
            //$pwd = array('pwd' => Hash::make($request->pwd));
            $data = array_merge($data,  $pwd);
        }

        $sip_account = Sip_account::find($request->id);
        $sip_account->update($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sip_accounts.update', 'element' => getElementByName('sip_accounts'), 'element_id' => $sip_account->id, 'source' => 'sip_accounts.update']);
        
        $sip_accounts = Sip_account::all();
        $returnHTML = view('sip_accounts/list', compact('sip_accounts'))->render();

        $sip_accounts = Sip_account::where('status', 1)->get();
        $returnHTMLRedux = view('sip_accounts/list-redux', compact('sip_accounts'))->render();
        return response()->json(['success' => 'SIP Account Updated', 'html' => $returnHTML, 'htmlRedux' => $returnHTMLRedux, 'sip_account' => $sip_account]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $sip_account = Sip_account::find($id);
        $sip_account->status = 0;
        $sip_account->end_date = today();
        if ($sip_account->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'sip_accounts.delete', 'element' => getElementByName('sip_accounts'), 'element_id' => $id, 'source' => 'sip_accounts.delete, ' . $id]);

            $sip_accounts = Sip_account::where('status', 1)->get();
            $returnHTMLRedux = view('sip_accounts/list-redux', compact('sip_accounts'))->render();
            return response()->json(['success' => 'SIP Account Deleted !!!', 'htmlRedux' => $returnHTMLRedux, 'sip_account' => $sip_account]);
        } else
            return response()->json(['error' => 'Failed to delete this SIP Account !!!']);
    }

    /**
     * Get All Call Logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCallsLogs()
    {
        $logs = Log::all();

        $returnHTML = view('sip_accounts/list-calls-logs', compact('logs'))->render();
        return response()->json(['success' => 'Calls Logs found', 'html' => $returnHTML]);
    }
}
