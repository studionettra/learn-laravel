<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


class KeyController extends Controller
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
        $keys = Key::all();
        $title = "Key Management";
        return view('key.index', compact('title', 'keys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('key.create');
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

        Key::create($request->all());
        Alert::success('Success!!', 'Key Was Created');
        return redirect()->to('role');
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
        $key = Key::findOrFail($id);

        return view('key.edit', compact('key', 'title'));
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

        Key::find($id)->update($data);
        return redirect()->to('key');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Key::find($id)->delete();
        Alert::success('Success!', 'Key Successfully Deleted');
        return redirect()->to('key');
    }
}
