<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Group;
use App\Models\Log;
use App\Models\User;
use App\Models\Users_permission;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $accounts = Account::where('status', 1)->get();
        $user = null;
        $users_permissions = [];
        $users = [];
        if ($groups->count() > 0) {
            $users = User::where('account_id', $groups->last()->account_id)->where('status', 1)->get();
            $user = $users->first();
            if ($user != null)
                $users_permissions = Users_permission::all()
                    ->where('user_id', $user->id);
        }
        return view('groups.list', [
            'groups' => $groups,
            'accounts' => $accounts,
            'users' => $users,
            'user' => $user,
            'users_permissions' => $users_permissions,
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
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users.groups.create', 'element' => getElementByName('groups'), 'element_id' => $group->id, 'source' => 'users.groups.create']);
        //return response()->json(['success' => 'New Group created !!!', 'group' => $group]);
        $groups = Group::All();
        $returnHTML = view('groups/datatable-groups', compact('groups'))->render();
        return response()->json(['success' => 'This group has been Added', 'html' => $returnHTML, 'group' => $group]);
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
        //return $group;
        $users = User::where('account_id', $group->account_id)->get();
        $user_id = null;
        if ($group != null) {
            $user = $users->first();
            if ($user != null)
                $user_id = $user->id;
        }
        if ($modal == 0) {
            $html = view('groups.group-info', compact('group', 'users'))->render();
            return response()->json(['success' => 'Group updated !!!', 'html' => $html, 'user_id' => $user_id]);
        }
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
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users.groups.create', 'element' => getElementByName('groups'), 'element_id' => $request->id, 'source' => 'users.groups.create']);
        $group = Group::find($request->id);
        array_push($data, ['account' => $group->account[0]->name, 'id' => $group->id]);
        //return response()->json(['success' => 'Group updated !!!', 'group' => $data]);
        $groups = Group::All();
        $returnHTML = view('groups/datatable-groups', compact('groups'))->render();
        return response()->json(['success' => 'This group has been Updated', 'html' => $returnHTML, 'group' => $group]);
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
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users.groups.delete', 'element' => getElementByName('groups'), 'element_id' => $id, 'source' => 'users.groups.delete, ' . $id]);
            //return response()->json(['success' => 'Group Deleted !!!', 'group' => $group]);
            $groups = Group::All();
            $returnHTML = view('groups/datatable-groups', compact('groups'))->render();
            return response()->json(['success' => 'This group has been deleted', 'html' => $returnHTML, 'group' => $group]);
        } else
            return response()->json(['error' => 'Failed to delete this group !!!']);
    }
}
