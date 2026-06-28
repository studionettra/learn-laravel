<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        $title = "Customer Management";
        $text = "Are you sure you want to delete?";
        confirmDelete("Delete Customer", $text);
        return view('customer.index', compact('customers', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Customer";
        return view('customer.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'customer_name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);

        try {
            Customer::create($validate);
            Alert::success('Success!!', 'Customer Was Created');
            return redirect()->to('customer');
        } catch (\Throwable $th) {
            Alert::error('Fail!!', 'An error occurred while saving the customer');
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
        $title = "Edit Customer";
        $edit = Customer::find($id);
        return view('customer.edit', compact('title', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'customer_name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);

        try {
            Customer::find($id)->update($validate);
            Alert::success('Success', 'Data Has Been Updated');
            return redirect()->to('customer');
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
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            Alert::success('Success!', 'Customer Has Been Deleted');
        }
        return redirect()->to('customer');
    }
}
