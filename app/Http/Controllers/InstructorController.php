<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Major;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::with('major')->orderByDesc('id')->get();
        // dd($instructors);
        // $users = User::latest()->get();
        // $users = User::orderByde
        $text = "Are you sure you want to delete?";
        $title = "Instructor Management";
        confirmDelete("Delete User", $text);
        return view('instructor.index', compact('instructors', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Instructor";
        $majors = Major::get();
        return view('instructor.create', compact('title', 'majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'major_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'major_id.required' => 'Please select a major.',
            'name.required' => 'Please enter a name.',
            'phone.required' => 'Please enter a phone number.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'password.required' => 'Please enter a password.',
            'password.min|6' => 'The password must be at least 6 characters.'
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            Instructor::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'major_id' => $request->major_id,
                'phone' => $request->phone
            ]);
            DB::commit();
            Alert::success('Success!!', 'Instructor Was Created');
            return redirect()->to('instructor');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('Fail!!', $th->getMessage());
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
        $title = "Edit Instructor";
        $edit = Instructor::with('user')->find($id);
        $majors = Major::get();  //blank
        // $edit = User::findOrFail($id); show 404
        return view('instructor.edit', compact('title', 'edit', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        DB::beginTransaction();
        try {
            $dataUser = [
                'name' => $request->name,
                'email' => $request->email
            ];
            $user = $instructor->user;
            if ($request->filled('password')) {
                $dataUser['password'] = $request->password;
            }

            $user->update($dataUser);

            $data = [
                'major_id' => $request->major_id,
                'name' => $request->name,
                'phone' => $request->phone,
            ];
            $instructor->update($data);
            DB::commit();
            Alert::success('Success!!', 'Update Instructor Success');
            return redirect()->to('instructor');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('Fail!!', $th->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {

        try {
            $instructor->user()->delete();
            Alert::success('Success!!', 'Delete Instructor Success');
            return redirect()->to('instructor');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('Fail!!', $th->getMessage());
            return back()->withInput();
        }
    }
}
