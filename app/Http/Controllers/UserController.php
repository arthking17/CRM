<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Note;
use App\Models\User;
use App\Models\Users_permission;
use DateTime;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
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
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();

        return view('users.create', [
            'accounts' => $accounts,
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
        $data = $request->validate([
            'username' => 'required|string|min:3|max:128|unique:users',
            'login' => 'required|string|min:3|max:128|unique:users',
            'pwd' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'role' => 'required|integer|min:1|max:3',
            'language' => 'required|string|min:2|max:5',
            'photo' => 'required|mimes:jpg,png,jpeg',
            'account_id' => 'required|exists:App\Models\Account,id',
        ]);
        $request->file('photo')->storePublicly('public/images/users');
        $data['photo'] = $request->file('photo')->hashName();
        $data['pwd'] = Hash::make($data['pwd']);
        $user = User::create($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'user.create', 'element' => 16, 'element_id' => $user->id, 'source' => 'user.create']);
        //return redirect(route('users'));
        return response()->json(['user' => $user, 'success' => 'This User has been added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Get user by id.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserById(int $id)
    {
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();
        $user = User::all()
            ->find($id);

        return view('users.edit', [
            'user' => $user,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Get user by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getUserJsonById(int $id, int $modal)
    {
        $user = User::all()
            ->find($id);
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();
        $notes = DB::table('notes')
            ->where('element', 16)
            ->where('element_id', $id)
            ->get();
        if ($modal == 0)
            return view('users/user-info', compact('user', 'notes'))->render();
        if ($modal == 1)
            return response()->json($user);
        //return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if ($request->input('pwd')) {
            $data = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'min:3',
                    'max:128',
                    Rule::unique('users')->ignore($id)
                ],
                'login' => [
                    'required',
                    'string',
                    'min:3',
                    'max:128',
                    Rule::unique('users')->ignore($id)
                ],
                'pwd' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'role' => 'required|integer|min:1|max:3',
                'language' => 'required|string|min:2|max:5',
                'photo' => 'mimes:jpg,png,jpeg',
                'account_id' => 'required|exists:App\Models\Account,id',
                'status' => 'required|integer|min:0|max:3',
            ]);
            $data['pwd'] = Hash::make($data['pwd']);
        } else {
            $data = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'min:3',
                    'max:128',
                    Rule::unique('users')->ignore($id)
                ],
                'login' => [
                    'required',
                    'string',
                    'min:3',
                    'max:128',
                    Rule::unique('users')->ignore($id)
                ],
                'role' => 'required|integer|min:1|max:3',
                'language' => 'required|string|min:2|max:5',
                'photo' => 'mimes:jpg,png,jpeg',
                'account_id' => 'required|exists:App\Models\Account,id',
                'status' => 'required|integer|min:0|max:3',
            ]);
        }
        $user = User::find($id);
        if ($request->hasFile('photo')) {
            Storage::delete('public/images/users/' . $user->photo);
            $request->file('photo')->storePublicly('public/images/users');
            $data['photo'] = $request->file('photo')->hashName();
        }
        $user->update($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'user.update', 'element' => 16, 'element_id' => $user->id, 'source' => 'user.update, ' . $id]);
        //return redirect(route('users'));
        return response()->json(['success' => 'This User has been edited']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        $user->status = 0;
        if ($user->save()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'user.delete', 'element' => 16, 'element_id' => $user->id, 'source' => 'user.delete, ' . $id]);
            return response()->json(['success' => 'This User has been Disabled !!!', 'user' => $user]);
        } else
            return response()->json(['error' => 'Failed to delete this user !!!']);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $user = User::find($id);
        $user->status = 1;
        if ($user->save()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'user.restore', 'element' => 16, 'element_id' => $user->id, 'source' => 'user.restore, ' . $id]);
            return response()->json(['success' => 'This User has been Actived !!!', 'user' => $user]);
        } else
            return response()->json(['error' => 'Failed to active this user !!!']);
    }

    /**
     * Get all Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers()
    {
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();
        $users = User::all();
        $users_paginate = User::all()->take(9);
        //$users_paginate = DB::table('users')->paginate(8);
        if($users->count() > 0){
            $logs = Log::all()
                ->where('user_id', $users[count($users) - 1]->id);
            $users_permissions = Users_permission::all()
                ->where('user_id', $users[count($users) - 1]->id);
            $notes = DB::table('notes')
                ->where('element', 16)->get();
        }else{
            $logs = null;
            $notes = null;
            $users_permissions = null;
        }

        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'users.show', 'element' => 16, 'element_id' => 0, 'source' => 'users']);

        return view('users.list', [
            'users' => $users,
            'users_paginate' => $users_paginate,
            'logs' => $logs,
            'users_permissions' => $users_permissions,
            'notes' => $notes,
            'accounts' => $accounts
        ]);
    }

    /**
     * pagination search 
     */
    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $users = DB::table('users')
                ->where('id', 'like', '%' . $query . '%')
                ->orWhere('username', 'like', '%' . $query . '%')
                ->orWhere('role', 'like', '%' . $query . '%')
                ->orWhere('status', 'like', '%' . $query . '%')
                ->orderBy($sort_by, $sort_type)
                ->paginate(8);
            return view('users/grid', compact('users'))->render();
        }
    }

    /**
     * list Logs
     */
    public function listLogs($user_id)
    {
        $logs = Log::all()
            ->where('user_id', $user_id);
        return view('users/logs', compact('logs'))->render();
    }

    /**
     * list users_permissions
     */
    public function listUsers_Permissions($user_id)
    {
        $users_permissions = Users_permission::all()
            ->where('user_id', $user_id);
        return view('users/users_permissions', compact('users_permissions'))->render();
    }

    /**
     * list All activity Logs
     */
    public function getAllLogs()
    {
        $logs = Log::all();
        return view('users/all-logs', [
            'logs' => $logs,
        ]);
    }
}
