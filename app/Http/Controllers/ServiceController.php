<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Session;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Services";

        $columns = [
            [
                'title'=>'ID',
                'key'=>'id'
            ],
            [
                'title'=>'Name',
                'key'=>'name'
            ],
            [
                'title'=>'Monthly Limit Amount',
                'key'=>'monthly_limit_amount'
            ]
        ];

        $data = Service::all();

        return view('admin.services.browse', compact('title','columns', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "New Service";
        $type = "new";
        return view('admin.services.add-edit', compact('title','type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:4',
            'monthly_limit_amount'=>'required|numeric'
        ]);

        $element = new Service();
        $element->name = $request->name;
        $element->monthly_limit_amount = $request->monthly_limit_amount;

        if($element->save()){
            Session::flash('success', 'Record Inserted Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Edit Service";
        $type = "edit";
        $data = Service::findorfail($id);
        return view('admin.services.add-edit', compact('title','type','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|min:4',
            'monthly_limit_amount'=>'required|numeric'
        ]);

        $element = Service::findorfail($id);
        $element->name = $request->name;
        $element->monthly_limit_amount = $request->monthly_limit_amount;

        if($element->update()){
            Session::flash('success', 'Record Update Successfully!!');
        }else{
            Session::flash('error', 'Error Updating The Record!!');
        }

        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $element = Service::findorfail($id);
        if($element->delete()){
            Session::flash('success', 'Record Deleted Successfully!!');
        }else{
            Session::flash('error', 'Error Deleting The Record!!');
        }

        return redirect()->route('services.index');
    }
}