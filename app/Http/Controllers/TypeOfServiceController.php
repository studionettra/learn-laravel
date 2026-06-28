<?php

namespace App\Http\Controllers;

use App\Models\TypeOfService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TypeOfServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = TypeOfService::orderBy('id', 'desc')->get();
        $title = "Service Type Management";
        $text = "Are you sure you want to delete?";
        confirmDelete("Delete Service", $text);
        return view('service.index', compact('services', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Service";
        return view('service.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'service_name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable'
        ]);

        try {
            TypeOfService::create($validate);
            Alert::success('Success!!', 'Service Was Created');
            return redirect()->to('service');
        } catch (\Throwable $th) {
            Alert::error('Fail!!', 'An error occurred while saving the service');
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
        $title = "Edit Service";
        $edit = TypeOfService::find($id);
        return view('service.edit', compact('title', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'service_name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable'
        ]);

        try {
            TypeOfService::find($id)->update($validate);
            Alert::success('Success', 'Data Has Been Updated');
            return redirect()->to('service');
        } catch (\Throwable $th) {
            Alert::error('Fail!', 'Update Failed!!');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = TypeOfService::find($id);
        if ($service) {
            $service->delete();
            Alert::success('Success!', 'Service Has Been Deleted');
        }
        return redirect()->to('service');
    }
}
