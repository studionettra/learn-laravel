<?php

namespace App\Http\Controllers;

use \App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\Role;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $text = "Are you sure you want to delete?";
        confirmDelete("Delete User", $text);
        $menus = Menu::all();
        $title = "Menu Management";
        return view('menu.index', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $title = "Create New Menu";
        $parents = Menu::whereNull('parent_id')->get();
        return view('menu.create', compact('title', 'roles', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'parent_id' => 'nullable|exists:menus,id',
            'name' => 'required|string',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $menu = Menu::create($validate);
        if ($request->roles) {
            $menu->roles()->attach($request->roles);
        }
        Alert::success('Success', 'Dat Berhasil ditambah!');
        return redirect()->route('menu.index');
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
        $menu = Menu::find($id);
        $roles = Role::all();
        $parents = Menu::where('parent_id', '=', null)->where('id', '!=', $menu->id)->get();
        // $menuRoles = take id at Roles that connected with table menus
        $menuRoles = $menu->roles->pluck('id')->toArray();
        return view('menu.edit', compact('menu', 'roles', 'parents', 'menuRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validate = $request->validate([
            'parent_id' => 'nullable|exists:menus,id',
            'name' => 'required|string',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);
        $menu->update($validate);
        $menu->roles()->sync($request->roles ?? []);

        Alert::success('Success', 'Dat Berhasil diubah!');
        return redirect()->route('menu.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        Alert::success('Success', 'Dat Berhasil dihapus!');
        return redirect()->route('menu.index');
    }
}
