<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Session;
use Auth;
use Storage;

class PersonController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Profiles";

        $columns = [
            [
                'title'=>'ID',
                'key'=>'id'
            ],
            [
                'title'=>'First Name',
                'key'=>'first_name'
            ],
            [
                'title'=>'Last Name',
                'key'=>'last_name'
            ],
            [
                'title'=>'Email',
                'key'=>'email'
            ],
            [
                'title'=>'Phone',
                'key'=>'phone'
            ],
            [
                'title'=>'Address',
                'key'=>'address'
            ]
        ];

        $data = Person::all();

        return view('admin.persons.browse', compact('title','columns', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "New Profile";
        $type = "new";
        return view('admin.persons.add-edit', compact('title','type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required|min:4',
            'last_name'=>'required|min:4',
            'email'=>'email|unique:persons',
            'phone'=>'numeric|unique:persons',
            'dni'=>'file|mimes:jpeg,jpg,png',
            'other_documents.*'=>'file|mimes:jpeg,jpg,png'
        ]);

        $element = new Person();
        $element->first_name = $request->first_name;
        $element->last_name = $request->last_name;
        $element->email = $request->email;
        $element->phone = $request->phone;
        $element->address = $request->address;
        $element->user_id = Auth::user()->id;

        $images = [];

        if($request->hasFile("dni")){
            $element->dni = $request->dni->store('public/persons/dnis');
        }

        if(count($request->other_documents) > 0){
            for($i=0;$i<count($request->other_documents);$i++){
                $images[] = $request->other_documents[$i]->store('public/persons/other_documents');
            }

            $element->other_documents = json_encode($images);
        }

        if($element->save()){
            Session::flash('success', 'Record Inserted Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('persons.index');
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
        $title = "Edit Profile";
        $type = "edit";
        $data = Person::findorfail($id);
        return view('admin.persons.add-edit', compact('title','type','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name'=>'required|min:4',
            'last_name'=>'required|min:4',
            'email'=>'email|unique:persons,email,'.$id,
            'phone'=>'numeric|unique:persons,phone,'.$id,
            'dni'=>'file|mimes:jpeg,jpg,png',
            'other_documents.*'=>'file|mimes:jpeg,jpg,png'
        ]);

        $element = Person::findorfail($id);

        $element->first_name = $request->first_name;
        $element->last_name = $request->last_name;
        $element->email = $request->email;
        $element->phone = $request->phone;
        $element->address = $request->address;

        $images = [];

        if($request->hasFile("dni")){
            if($element->dni){
                Storage::delete($element->dni);
            }
            
            $element->dni = $request->dni->store('public/persons/dnis');
        }

        if(count($request->other_documents) > 0){

            foreach( json_decode($element->other_documents) as $od ){
                $images[] = $od;
            }

            for($i=0;$i<count($request->other_documents);$i++){
                $images[] = $request->other_documents[$i]->store('public/persons/other_documents');
            }

            $element->other_documents = json_encode($images);
        }

        if($element->update()){
            Session::flash('success', 'Record Update Successfully!!');
        }else{
            Session::flash('error', 'Error Updating The Record!!');
        }

        return redirect()->route('persons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $element = Person::findorfail($id);

        if($element->dni){
           Storage::delete($element->dni); 
        }

        if(count(json_decode($element->other_documents)) > 0){
            foreach(json_decode($element->other_documents) as $od){
                Storage::delete($od);
            }
        }
        
        if($element->delete()){
            Session::flash('success', 'Record Deleted Successfully!!');
        }else{
            Session::flash('error', 'Error Deleting The Record!!');
        }

        return redirect()->route('persons.index');
    }

    public function deleteImage(Request $request){
        $person = Person::findorfail($request->person_id);
        $images = [];

        foreach(json_decode($person->other_documents) as $od){
            if($request->delete_image != $od){
                $images[] = $od;
            }else{
                Storage::delete($od);
            }
        }

        $person->other_documents = json_encode($images);

        if($person->update()){
            return redirect()->back()->with(['success'=>'Image Deleted Successfully!!']);
        }else{
            return Redirect()->back()->with(['error'=>'Error Deleting The Image!!']);
        }
    }
}