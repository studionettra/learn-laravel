<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
// use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        // $users = User::latest()->get();
        // $users = User::orderByde
        $text = "Are you sure you want to delete?";
        $title = "User Management";
        // $userRoles = UserRole::with('user', 'role')->orderByDesc('id')->get();
        confirmDelete("Delete User", $text);
        return view('user.index', compact('users', 'title', 'text'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New User";
        $roles = Role::get();
        return view('user.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:6'
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->roles()->sync($request->role_ids);

            DB::commit();
            Alert::success('Success!!', 'User Role Was Created');
            return redirect()->to('user');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('fail!!', 'An error occurred while saving the user');
            return back()->withInput();
        }
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
        $title = "Edit User";
        $edit = User::find($id); //blank
        $roles = Role::get();
        // $edit = User::findOrFail($id); show 404
        return view('user.edit', compact('title', 'edit', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            // If user don't enter the password
            if (filled($request->password)) {
                $data['password'] = $request->password;
            }
            $user = User::find($id);
            $user->update($data);
            $user->roles()->sync($request->role_ids);
            DB::commit();
            Alert::success('Success', 'Data Has Been Update');
            return redirect()->to('user');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('Fail!', 'Update Failed!!');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Success!', 'User Role Has Been Deleted');
        return redirect()->to('user');
    }
}
