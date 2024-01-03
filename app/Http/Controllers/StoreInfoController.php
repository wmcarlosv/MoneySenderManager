<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreInfo;
use Storage;
use Session;

class StoreInfoController extends Controller
{
    public function index(){
        $title = "Store Info";
        $data = [];
        $si = StoreInfo::all();

        if($si->count() > 0){
            $data = $si[0];
        }

        return view('admin.store_info.index', compact('title','data'));
    }

    public function save_store_info(Request $request){
        $store_info = null;
        $si = StoreInfo::all();
        if($si->count() > 0){
            $store_info = StoreInfo::findorfail($si[0]->id);
        }else{
            $store_info = new StoreInfo();
        }

        $store_info->name = $request->name;
        
        if($request->hasFile('logo')){
            
            if($si->count() > 0){
                if($si[0]->logo){
                    Storage::delete($si[0]->logo);  
                }
            }

            $store_info->logo = $request->logo->store('public/store_info/logo');
        }

        $store_info->address = $request->address;
        $store_info->phone = $request->phone;

        if($store_info->save()){
            Session::flash('success','Store Info Updated!!');
        }else{
            Session::flash('error','Error Updating Store Info!!');
        }

        return redirect()->route('store_info.get');
    }
}
