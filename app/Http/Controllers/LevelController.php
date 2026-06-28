<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use RealRashid\SweetAlert\Facades\Alert;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('id', 'desc')->get();
        $title = "Level Management";
        return view('level.index', compact('levels', 'title'));
    }

    public function create()
    {
        $title = "Create New Level";
        return view('level.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'level_name' => 'required',
        ]);

        Level::create($request->all());
        Alert::success('Success!!', 'Level Was Created');
        return redirect()->to('level');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $title = "Edit Level";
        $edit = Level::find($id);
        return view('level.edit', compact('title', 'edit'));
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'level_name' => $request->level_name,
        ];

        Level::find($id)->update($data);
        return redirect()->to('level');
    }

    public function destroy(string $id)
    {
        Level::find($id)->delete();
        return redirect()->to('level');
    }
}
