<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Major;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('major')->orderByDesc('id')->get();
        // dd($students);
        // $users = User::latest()->get();
        // $users = User::orderByde
        // $text = "Are you sure you want to delete?";
        $title = "Student Management";
        // confirmDelete("Delete User", $text);
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
        $validate = $request->validate([
            'major_id' => 'required',
            'name' => 'required',
            'phone' => 'nullable'
        ]);

        Student::create($request->all());
        Alert::success('Success!!', 'Student Was Created');
        return redirect()->to('student');
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
        $edit = Student::find($id);
        $majors = Major::get();  //blank
        // $edit = User::findOrFail($id); show 404
        return view('student.edit', compact('title', 'edit', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = [
            'major_id' => $request->major_id,
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        Student::find($id)->update($data);
        return redirect()->to('student');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::find($id)->delete();
        return redirect()->to('student');
    }
}
