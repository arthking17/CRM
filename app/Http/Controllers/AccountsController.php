<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'status' => 'required|integer',
        ]);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status');
        $account = account::create(['name' => $name, 'url' => $url, 'status' => $status, 'start_date' => today()]);
        /*if ($status == 0) {
            $account = account::create(['name' => $name, 'url' => $url, 'status' => $status, 'start_date' => today(), 'end_date' => today()]);
        } else
            $account = account::create(['name' => $name, 'url' => $url, 'status' => $status, 'start_date' => today()]);*/
        //return redirect(route('accounts'));
        return response()->json($account);
    }

    /**
     * Get all accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAccounts()
    {
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();

        return view('accounts.list', [
            'accounts' => $accounts,
        ]);
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
            'status' => 'required|integer',
        ]);
        $accounts = Account::all();
        $account = $accounts
            ->find($request->input('id'));
        $account->name = $request->input('name');
        $account->url = $request->input('url');
        /*if ($account->status == 1 && $account->status != $request->input('status')) {
            $account->end_date = today();
        }*/
        $account->status = $request->input('status');
        $account->save();
        return response()->json($account);
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
        if ($account->save())
            return response()->json(['success' => 'Account has been Disabled !!!', 'account' => $account]);
        else
            return response()->json(['error' => 'Failed to delete account !!!']);
        /*if ($account->delete())
            return response()->json(['success' => 'Account has been deleted !!!']);
        else
            return response()->json(['error' => 'Failed to delete account !!!']);*/
    }
}
