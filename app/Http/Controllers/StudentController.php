<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Major;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('major', 'user')->orderByDesc('id')->get();
        // dd($students);
        // $users = User::latest()->get();
        // $users = User::orderByde
        $text = "Are you sure you want to delete?";
        $title = "Student Management";
        confirmDelete("Delete User", $text);
        return view('student.index', compact('students', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Student";
        $majors = Major::get();
        return view('student.create', compact('title', 'majors'));
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
            Student::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'major_id' => $request->major_id,
                'phone' => $request->phone
            ]);
            DB::commit();
            Alert::success('Success!!', 'Student Was Created');
            return redirect()->to('student');
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
        $title = "Edit Student";
        $edit = Student::with('user')->find($id);
        $majors = Major::get();  //blank
        // $edit = User::findOrFail($id); show 404
        return view('student.edit', compact('title', 'edit', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {

        DB::beginTransaction();

        try {
            $dataUser = [
                'name' => $request->name,
                'email' => $request->email
            ];
            $user = $student->user;
            if ($request->filled('password')) {
                $dataUser['password'] = $request->password;
            }

            $user->update($dataUser);

            $data = [
                'major_id' => $request->major_id,
                'name' => $request->name,
                'phone' => $request->phone,
            ];
            $student->update($data);
            DB::commit();
            Alert::success('Success!!', 'Update Student Success');
            return redirect()->to('student');
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
    public function destroy(Student $student)
    {
        try {
            $student->user()->delete();
            Alert::success('Success!!', 'Delete Student Success');
            return redirect()->to('student');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            Alert::error('Fail!!', $th->getMessage());
            return back()->withInput();
        }
    }
}
