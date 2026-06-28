<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


class LockerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        confirmDelete(
            'Delete Locker?',
            'Are you sure you want to delete this locker?'
        );
        $lockers = locker::all();
        $title = "Locker Management";
        return view('locker.index', compact('title', 'lockers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locker.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'locker_name' => 'required|unique:lockers,locker_name',
            'batch' => 'required|in:1,2,3,4',
            'major_name' => 'required|in:Web Programming,Content Creator,Multimedia',
            'status' => 'required|in:Available,Unavailable,Damaged,Missing'
        ]);
        Locker::create([
            'locker_name' => $request->locker_name,
            'batch' => $request->batch,
            'major_name' => $request->major_name,
            'status' => $request->status
        ]);
        Alert::success('Success!', 'Data Success Added');
        return redirect()->route('locker.index');
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
        $title = "Edit Locker";
        $locker = Locker::findOrFail($id);

        return view('locker.edit', compact('locker', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'locker_name' => 'required|' . Rule::unique("lockers", "locker_name")->ignore($id),
            'batch' => 'required|in:1,2,3,4',
            'major_name' => 'required|in:Web Programming,Content Creator,Multimedia',
            'status' => 'required|in:Available,Unavailable,Damaged,Missing'
        ]);
        $data = Locker::find($id);
        $data->update(
            $request->all()
        );
        Alert::success('Success!', 'Data Successfully Updated');
        return redirect()->route('locker.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Locker::find($id)->delete();
        Alert::success('Success!', 'Data Successfully Deleted');
        return redirect()->to('locker');
    }
}
