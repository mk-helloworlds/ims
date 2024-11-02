<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRolePermissionRequest;
use App\Http\Requests\UpdateUserRolePermissionRequest;
use App\Models\UserRolePermission;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserRolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Using Query Builder
        $results = DB::table('user_role_permissions')
                ->join('users', 'user_role_permissions.user_id', '=', 'users.id')
                ->join('user_roles', 'user_role_permissions.role_id', '=', 'user_roles.id')
                ->select('user_role_permissions.*', 'users.name as user_name', 'user_roles.role_name as role_name')
                ->paginate(10);

        return view('back_end.preference.user_role_permission.index')->with(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DB::table('users')->select('id', 'name')->get();
        $roles = DB::table('user_roles')->select('id', 'role_name')->get();

        return view('back_end.preference.user_role_permission.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user_role_permission = new UserRolePermission([
            'user_id' => $request->input('user_id'),
            'role_id' => $request->input('role_id'),
        ]);

        if($user_role_permission->save()){
            return redirect()->route('user_role_permission.index')->with('success','User created successfully.');
        }

        return back()->with('error', 'User Can not be created, Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRolePermission $userRolePermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRolePermission $user_role_permission)
    {
        $users = DB::table('users')->select('id', 'name')->get();
        $roles = DB::table('user_roles')->select('id', 'role_name')->get();

        return view("back_end.preference.user_role_permission.edit", compact('users','roles','user_role_permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRolePermission $userRolePermission)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $userRolePermission->user_id = $request->input('user_id');
        $userRolePermission->role_id = $request->input('role_id');
    
        // Save the updated model
        if ($userRolePermission->save()) {
            return redirect()->route('user_role_permission.index')->with('success', 'User updated successfully.');
        }
    
        // If save fails, redirect back with an error
        return back()->with('error', 'User cannot be updated, Please try again.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRolePermission $userRolePermission)
    {
        $userRolePermission->delete();
        return redirect()->route('user_role_permission.index')->with('success', 'User Deleted successfully');
    }
}
