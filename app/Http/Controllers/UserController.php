<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Users";

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
                'title'=>'Email',
                'key'=>'email'
            ],
            [
                'title'=>'Role',
                'key'=>'role'
            ]
        ];

        $data = User::all();

        return view('admin.users.browse', compact('title','columns', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "New User";
        $type = "new";
        return view('admin.users.add-edit', compact('title','type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:4',
            'email'=>'required|email|unique:users',
            'role'=>'required',
            'password'=>'required|min:8|max:16'
        ]);

        $element = new User();
        $element->name = $request->name;
        $element->email = $request->email;
        $element->role = $request->role;
        $element->password = bcrypt($request->password);

        if($element->save()){
            Session::flash('success', 'Record Inserted Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('users.index');
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
        $title = "Edit User";
        $type = "edit";
        $data = User::findorfail($id);
        return view('admin.users.add-edit', compact('title','type','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|min:4',
            'email'=>'required|email|unique:users,email,'.$id,
            'role'=>'required'
        ]);

        $element = User::findorfail($id);
        $element->name = $request->name;
        $element->email = $request->email;
        $element->role = $request->role;

        if($element->update()){
            Session::flash('success', 'Record Update Successfully!!');
        }else{
            Session::flash('error', 'Error Updating The Record!!');
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $element = User::findorfail($id);
        if($element->delete()){
            Session::flash('success', 'Record Deleted Successfully!!');
        }else{
            Session::flash('error', 'Error Deleting The Record!!');
        }

        return redirect()->route('users.index');
    }

    public function profile(){
        $title = "Profile";

        return view('admin.users.profile',compact('title'));
    }

    public function update_profile(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.Auth::user()->id
        ]);

        $user = User::findorfail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($user->update()){
            Session::flash('success','Record Insert Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('profile');
    }

    public function change_password(Request $request){
        $request->validate([
            'password'=>'required|min:8|max:16|same:password_confirmation',
            'password_confirmation'=>'required|min:8|max:16'
        ]);

        $user = User::findorfail(Auth::user()->id);
        $user->password = bcrypt($request->password);

        if($user->update()){
            Session::flash('success','Password Changed Successfully!!');
        }else{
            Session::flash('error', 'Error Changing The Passsword!!');
        }

        return redirect()->route('profile');
    }
}
