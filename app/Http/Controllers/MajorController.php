<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // confirmDelete(
        //     'Delete Locker?',
        //     'Are you sure you want to delete this locker?'
        // );
        $majors = Major::all();
        $title = "Major Management";
        return view('major.index', compact('title', 'majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create New Major';
        return view('major.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'is_active' => 'required'
        ]);

        Major::create($request->all());
        Alert::success('Success!!', 'Major Was Created');
        return redirect()->to('major');
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
        $title = "Edit Major";
        $major = Major::findOrFail($id);
        $edit = Major::find($id);
        return view('major.edit', compact('major', 'title', 'edit'));
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

        Major::find($id)->update($data);
        return redirect()->to('major');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Major::find($id)->delete();
        Alert::success('Success!', 'Major Successfully Deleted');
        return redirect()->to('major');
    }
}
