<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Session;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Countries";

        $columns = [
            [
                'title'=>'ID',
                'key'=>'id'
            ],
            [
                'title'=>'Name',
                'key'=>'name'
            ]
        ];

        $data = Country::all();

        return view('admin.countries.browse', compact('title','columns', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "New Country";
        $type = "new";
        return view('admin.countries.add-edit', compact('title','type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:4'
        ]);

        $element = new Country();
        $element->name = $request->name;

        if($element->save()){
            Session::flash('success', 'Record Inserted Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('countries.index');
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
        $title = "Edit Country";
        $type = "edit";
        $data = Country::findorfail($id);
        return view('admin.countries.add-edit', compact('title','type','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|min:4'
        ]);

        $element = Country::findorfail($id);
        $element->name = $request->name;

        if($element->update()){
            Session::flash('success', 'Record Update Successfully!!');
        }else{
            Session::flash('error', 'Error Updating The Record!!');
        }

        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $element = Country::findorfail($id);
        if($element->delete()){
            Session::flash('success', 'Record Deleted Successfully!!');
        }else{
            Session::flash('error', 'Error Deleting The Record!!');
        }

        return redirect()->route('countries.index');
    }
}
