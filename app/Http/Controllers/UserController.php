<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        //return $request->file('photo');
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
            'role' => 'required|integer|min:1|max:1',
            'language' => 'required|string|min:2|max:5',
            'photo' => 'required|mimes:jpg,png,jpeg',
            'timezone' => 'required',
            'browser' => 'required|string|min:3|max:255',
            'ip_address' => 'required|ip',
            'account_id' => 'required|exists:App\Models\Account,id',
            'status' => 'required|integer|min:1|max:1',
        ]);
        $request->file('photo')->storePublicly('public/images/users');
        $data['photo'] = $request->file('photo')->hashName();
        $data['pwd'] = Hash::make($data['pwd']);
        $user = User::create($data);
        return redirect(route('users'));
        return response()->json([$user, 'message', "This User has been added"]);
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
                'language' => 'required|string|min:2|max:4',
                'photo' => 'mimes:jpg,png,jpeg',
                'timezone' => 'required', //timezone
                'browser' => 'required|string|min:3|max:255',
                'ip_address' => 'required|ip',
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
                'language' => 'required|string|min:2|max:4',
                'photo' => 'mimes:jpg,png,jpeg',
                'timezone' => 'required',//timezone
                'browser' => 'required|string|min:3|max:255',
                'ip_address' => 'required|ip',
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
        return redirect(route('users'));
        return response()->json(['message', "This User has been edited"]);
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
        if ($user->save())
            return response()->json(['success' => 'This User has been Disabled !!!', 'user' => $user]);
        else
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
        if ($user->save())
            return response()->json(['success' => 'This User has been Actived !!!', 'user' => $user]);
        else
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
        $users = DB::table('users')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('users.list', [
            'users' => $users,
            'accounts' => $accounts
        ]);
    }
}
