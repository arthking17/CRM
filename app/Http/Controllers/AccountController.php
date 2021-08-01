<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::All();

        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'accounts.show', 'element' => 1, 'element_id' => 0, 'source' => 'accounts']);

        return view('accounts.list', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'url' => 'required|url',
            'status' => 'required|integer|digits_between:1,1',
        ]);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status');
        $account = Account::create(['name' => $name, 'url' => $url, 'status' => $status, 'start_date' => today()]);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'account.create', 'element' => 1, 'element_id' => $account->id, 'source' => 'account.create']);
        $accounts = Account::All();
        $returnHTML = view('accounts/datatable-accounts', compact('accounts'))->render();
        return response()->json(['success' => 'Account has been Added !!!', 'html' => $returnHTML, 'account' => $account]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Get account by id.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccountById(int $id)
    {
        $account = Account::all()
            ->find($id);

        return response()->json($account);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'url' => 'required|url',
            'status' => 'required|integer|digits_between:1,1',
        ]);
        $accounts = Account::all();
        $account = $accounts
            ->find($request->input('id'));
        $account->name = $request->input('name');
        $account->url = $request->input('url');
        $account->status = $request->input('status');
        $account->save();
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'account.update', 'element' => 1, 'element_id' => $account->id, 'source' => 'account.update']);
        $accounts = Account::All();
        $returnHTML = view('accounts/datatable-accounts', compact('accounts'))->render();
        return response()->json(['success' => 'Account has been Updated !!!', 'html' => $returnHTML, 'account' => $account]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $account = Account::all()
            ->find($id);
        $account->status = 0;
        $account->end_date = today();
        if ($account->save()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'account.delete', 'element' => 1, 'element_id' => $account->id, 'source' => 'account.delete, ' . $id]);
            $accounts = Account::All();
            $returnHTML = view('accounts/datatable-accounts', compact('accounts'))->render();
            return response()->json(['success' => 'Account has been Disabled !!!', 'html' => $returnHTML, 'account' => $account]);
        } else
            return response()->json(['error' => 'Failed to delete account !!!']);
    }
}
