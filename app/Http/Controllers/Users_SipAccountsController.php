<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Users_SipAccount;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Users_SipAccountsController extends Controller
{
    /**
     * retrieve all users_sip_accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUserSipAccounts()
    {
        if(Auth::user()->role == 1){
            $users_sip_accounts = Users_SipAccount::all();
            return response()->json($users_sip_accounts);
        }else if(Auth::user()->role == 2){
            $users_sip_accounts = Users_SipAccount::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            return response()->json($users_sip_accounts);
        }else{
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
    }

    /**
     * retrieve Users_SipAccount by id.
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function get(int $id)
    {
        $users_sip_account = Users_SipAccount::find($id);
        return response()->json(['users_sip_account' => $users_sip_account]);
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
            'user_id' => 'required|exists:App\Models\User,id',
            'sipaccount_id' => 'required|exists:App\Models\Sip_account,id',
        ]);

        $start_date = array('start_date' => today());
        $data = array_merge($data,  $start_date);

        $users_sip_account = Users_SipAccount::create($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users_sip_accounts.create', 'element' => getElementByName('users_sip_accounts'), 'element_id' => $users_sip_account->id, 'source' => 'users_sip_accounts.create']);

        if(Auth::user()->role == 1){
            $users_sip_accounts = Users_SipAccount::all();
        }else if(Auth::user()->role == 2){
            $users_sip_accounts = Users_SipAccount::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        }else{
            $users_sip_accounts = [];
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }

        $returnHTML = view('users_sip_accounts/list', compact('users_sip_accounts'))->render();
        return response()->json(['success' => 'Users Sip Account Created', 'html' => $returnHTML, 'users_sip_account' => $users_sip_account]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users_SipAccount  $users_sip_account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Users_SipAccount,id',
            'user_id' => 'required|exists:App\Models\User,id',
            'sipaccount_id' => 'required|exists:App\Models\Sip_account,id',
        ]);

        $users_sip_account = Users_SipAccount::find($request->id);
        $users_sip_account->update($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users_sip_accounts.update', 'element' => getElementByName('users_sip_accounts'), 'element_id' => $users_sip_account->id, 'source' => 'users_sip_accounts.update']);

        $users_sip_account->user_id = $users_sip_account->user[0]->username;
        $users_sip_account->sipaccount_id = $users_sip_account->sipaccount[0]->name;
        return response()->json(['success' => 'Users Sip Account Updated', 'users_sip_account' => $users_sip_account]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $users_sip_account = Users_SipAccount::find($id);
        $users_sip_account->status = 0;
        $users_sip_account->end_date = today();
        if ($users_sip_account->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users_sip_accounts.delete', 'element' => getElementByName('users_sip_accounts'), 'element_id' => $id, 'source' => 'users_sip_accounts.delete, ' . $id]);

            $users_sip_accounts = Users_SipAccount::find($id);
            return response()->json(['success' => 'Users Sip Account Deleted !!!', 'users_sip_accounts' => $users_sip_accounts]);
        } else
            return response()->json(['error' => 'Failed to delete this Users Sip Account !!!']);
    }
}
