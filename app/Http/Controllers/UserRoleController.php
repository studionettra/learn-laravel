<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $text = "Are you sure you want to delete?";
        confirmDelete("Delete User Role", $text);
        $title = "User Role Management";
        $userRoles = UserRole::with('user', 'role')->orderByDesc('id')->get();
        return view('user-role.index', compact('userRoles', 'title', 'text'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $roles = Role::get();
        $title = "Create New User Role";
        return view('user-role.create', compact('title', 'users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        UserRole::create($request->all());
        Alert::success('Success!!', 'User Role Was Created');
        return redirect()->to('user-role');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Edit Role";
        $edit = Role::find($id); //blank
        // $edit = User::findOrFail($id); show 404
        return view('role.edit', compact('title', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = [
            'name' => $request->name,
            'is_active' => $request->is_active,
        ];

        Role::find($id)->update($data);
        return redirect()->to('role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::find($id)->delete();
        return redirect()->to('role');
    }
}
