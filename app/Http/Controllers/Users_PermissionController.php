<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Users_Permission;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //return $request;
        $data = $request->validate([
            'user_id' => 'required|integer|digits_between:1,10',
            'element' => 'required',
            'dependency' => 'required|integer|min:0|max:1',
            'create' => 'nullable',
            'show' => 'nullable',
            'update' => 'nullable',
            'delete' => 'nullable',
        ]);
        $codes = ['create', 'show', 'update', 'delete'];
        $element = getElementName($request->element);

        $users_permissions = DB::table('users_permissions')
            ->where('user_id', $request->user_id)
            ->where('code', $element . '.create')
            ->where('status', 1)
            ->get();

        foreach ($codes as $code) {
            if (isset($data[$code])) {
                Users_Permission::create(['user_id' => $request->user_id, 'code' => $element . '.' . $code, 'dependency' => $request->dependency]);
            }else{
                Users_Permission::create(['user_id' => $request->user_id, 'code' => $element . '.' . $code, 'dependency' => $request->dependency, 'status' => 0]);
            }
        }
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'users_permission.create', 'element' => 17, 'element_id' => $request->user_id, 'source' => 'users_permission.create']);
        return response()->json(['user_id' => $request->user_id, 'success' => 'User permission added']);
    }

    /**
     * Get user permissions by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getUserPermissionsJsonById(int $id, int $modal)
    {
        $users_permissions = DB::table('users_permissions')
            ->where('user_id', $id)
            ->where('status', 1)
            ->get();
        $user = User::find($id);
        if ($modal == 0)
            return view('permissions/users-permissions-info', compact('users_permissions', 'user'))->render();
        if ($modal == 1)
            return response()->json($users_permissions);
        //return response()->json($user);
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
