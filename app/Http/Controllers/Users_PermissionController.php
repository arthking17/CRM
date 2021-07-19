<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Users_Permission;
use DateTime;
use Illuminate\Http\Request;

class Users_PermissionController extends Controller
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
        $data = $request->validate([
            'user_id' => 'required|integer|digits_between:1,10',
            'code' => 'required',
            'dependency' => 'required|integer|min:0|max:1',
        ]);
        $users_Permission = Users_Permission::create($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'users_permission.create', 'element' => 17, 'element_id' => $users_Permission->user_id, 'source' => 'users_permission.create']);
        return response()->json(['users_permission' => $users_Permission, 'success' => 'User permission added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users_Permission  $users_Permission
     * @return \Illuminate\Http\Response
     */
    public function show(Users_Permission $users_Permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users_Permission  $users_Permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Users_Permission $users_Permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users_Permission  $users_Permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users_Permission $users_Permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users_Permission  $users_Permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $code)
    {
        $users_permission = Users_Permission::where('user_id', $user_id)->Where('code', $code)->update(['status' => 0]);
        if ($users_permission) {
            $users_permission = Users_Permission::where('user_id', $user_id)->Where('code', $code)->first();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'users_permission.delete', 'element' => 16, 'element_id' => $users_permission->user_id, 'source' => 'users_permission.delete, ["user_id":' . $users_permission->user_id . ', "code" : ' . $users_permission->code . ']']);
            return response()->json(['success' => 'This user permission has been Disabled !!!', 'users_permission' => $users_permission]);
        }
    }
}
