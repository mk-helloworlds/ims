<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = UserRole::paginate(10);
        return view('back_end.preference.user_role.index')->with(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back_end.preference.user_role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'role_name' => 'required',
        ]);

        // If validation passes, proceed to store the role
        $user_role = new UserRole([
            'role_name' => $request->input('role_name'),
        ]);

        if ($user_role->save()) {
            // Redirect back with a success message
            return redirect()->route('user_role.index')->with('success', 'User roles created successfully.');
        }

        return back()->with('error', 'User Can not be created, Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        // return view("back_end.preference.user_role.edit");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $user_role)
    {
        return view('back_end.preference.user_role.edit', compact('user_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRole $user_role)
    {
        $request->validate([
            'role_name' => 'required',
        ]);

        $requestData = [];

        foreach ($request->all() as $key => $value) {
            if (! empty($value)) {
                $requestData[$key] = $value;
            }
        }

        if ($user_role->update($requestData)) {
            return redirect()->route('user_role.index')->with('success', 'User updated successfully!');
        }

        return back()->with('error', 'User can not be updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $user_role)
    {
        $user_role->delete();

        return redirect()->route('user_role.index')->with('success', 'User Deleted successfully');
    }
}
