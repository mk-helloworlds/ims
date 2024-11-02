<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Dflydev\DotAccessData\Data;

class UserController extends Controller
{
    public function index()
    {
        $results = User::with("role")->paginate(10);
        
        return view('back_end.preference.user.index')->with(['results' => $results]);
    }

    public function create()
    {
        $userRoles = UserRole::get();

        $data = array(
            'roles'=>$userRoles
        );
        
        return view('back_end.preference.user.create')->with($data);
    }

    public function store(StoreUserRequest $request)
    {
        // Validate the User Input from Front-End
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'user_role_id' => 'required',
            'img_profile' => 'required|mimes:png,jpng',
        ]);

        // If the Validation Pass the test -> Procceed with Storing data
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'user_role_id' => $request->input('user_role_id'),
            'password' => bcrypt($request->input('password')),
            'img_profile' => $request->file('img_profile')->store('profiles', 'public'),
        ]);

        if ($user->save()) {
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        }

        return back()->with('error', 'User Can not be created, Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('back_end.preference.user.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userRoles = UserRole::get();
        
        $data = array(
            'roles'=>$userRoles
        );
        
        return view('back_end.preference.user.edit', compact('user'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validate([
            'name' => '',
            'user_role_id' => '',
            'email' => 'email|unique:users,email,'.$user->id.',id',
            'password' => '',
            'img_profile' => 'mimes:png,jpng',
        ]);

        $requestData = [];
        
        foreach ($request->all() as $key => $value) {
            if (!empty($value)) {
                $requestData[$key] = $value;
            }
        }

        if ($user->update($requestData)) {
            return redirect()->route('user.index')->with('success', 'User updated successfully!');
        }

        return back()->with('error', 'User can not be updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('user.index')->with('success', 'User Deleted successfully!');
    }
}
