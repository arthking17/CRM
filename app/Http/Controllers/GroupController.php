<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Group;
use App\Models\Log;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::All();
        $accounts = Account::All();
        $users = User::all();
        return view('contacts.groups.list', [
            'groups' => $groups,
            'accounts' => $accounts,
            'users' => $users,
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
        $data = $request->validate([
            'name' => 'required|min:3|unique:groups',
            'account_id' => 'required|exists:App\Models\Account,id',
        ]);
        $group = Group::create($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.groups.create', 'element' => 10, 'element_id' => $group->id, 'source' => 'contacts.groups.create']);
        return response()->json(['success' => 'New Group created !!!', 'group' => $group]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Get Group by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getGroupJsonById(int $id, int $modal)
    {
        $group = Group::all()
            ->find($id);
        $users = User::all();
        if ($modal == 0)
            return view('contacts.groups.group-info', compact('group', 'users'))->render();
        if ($modal == 1)
            return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'min:3',
                Rule::unique('groups')->ignore($request->id)
            ],
            'account_id' => 'required|exists:App\Models\Account,id',
        ]);
        Group::find($request->id)->update($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.groups.create', 'element' => 10, 'element_id' => $request->id, 'source' => 'contacts.groups.create']);
        $group = Group::find($request->id);
        array_push($data, ['account' => $group->account[0]->name, 'id' => $group->id]);
        return response()->json(['success' => 'Group updated !!!', 'group' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $group = Group::find($id);
        if ($group->delete()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.groups.delete', 'element' => 16, 'element_id' => $id, 'source' => 'contacts.groups.delete, ' . $id]);
            return response()->json(['success' => 'Group Deleted !!!', 'group' => $group]);
        } else
            return response()->json(['error' => 'Failed to delete this group !!!']);
    }
}
