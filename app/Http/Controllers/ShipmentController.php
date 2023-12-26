<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Person;
use App\Models\Country;
use App\Models\Service;
use Session;
use Auth;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Activities";

        $columns = [
            [
                'title'=>'Date',
                'key'=>'created_at'
            ],
            [
                'title'=>'Sender Name',
                'key'=>'sender'
            ],
            [
                'title'=>'Receiver Name',
                'key'=>'receiver'
            ],
            [
                'title'=>'Country',
                'key'=>'country'
            ],
            [
                'title'=>'Service',
                'key'=>'service'
            ],
            [
                'title'=>'Amount',
                'key'=>'amount'
            ]
        ];

        $shipments = Shipment::with('sender','country','service')->get();
        $data = [];
        $cont = 0;

        foreach($shipments as $ship){

            $data[$cont] = [
                'id'=>$ship->id,
                'created_at'=>$ship->shipment_date,
                'sender'=>$ship->sender->full_name,
                'receiver'=>$ship->receiver_person_id,
                'country'=>$ship->country->name,
                'service'=>$ship->service->name,
                'amount'=>number_format($ship->amount,'2','.',',')."$"
            ];

            $cont++;
        }

        $data = json_decode(json_encode($data));

        return view('admin.shipments.browse', compact('title','columns', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "New Activity";
        $type = "new";

        $options = [
            'persons'=>Person::all(),
            'countries'=>Country::all(),
            'services'=>Service::all()
        ];

        return view('admin.shipments.add-edit', compact('title','type', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_person_id'=>'required',
            'receiver_person_id'=>'required',
            'country_id'=>'required',
            'service_id'=>'required',
            'amount'=>'required|numeric'
        ]);

        $sender_person_id = null;

        if( filter_var($request->sender_person_id, FILTER_VALIDATE_INT) === false ){
            $person = Person::whereRaw('LOWER(first_name) = (?)',[strtolower($request->sender_person_id)])->get();
            if($person->count() > 0){
                $sender_person_id = $person[0]->id;
            }else{
                $person = new Person();
                $person->first_name = ucwords($request->sender_person_id);
                $person->user_id = Auth::user()->id;
                $person->save();
                $sender_person_id = $person->id;
            }
        }else{
            $sender_person_id = $request->sender_person_id;
        }

        $element = new Shipment();
        $element->sender_person_id = $sender_person_id;
        $element->receiver_person_id = $request->receiver_person_id;
        $element->country_id = $request->country_id;
        $element->service_id = $request->service_id;
        $element->amount = $request->amount;
        $element->user_id = Auth::user()->id;
        $element->shipment_date = date('Y-m-d');

        if($element->save()){
            Session::flash('success', 'Record Inserted Successfully!!');
        }else{
            Session::flash('error', 'Error Inserting The Record!!');
        }

        return redirect()->route('shipments.index');
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
        $title = "Edit Activity";
        $type = "edit";
        $data = Shipment::findorfail($id);
        
        $options = [
            'persons'=>Person::all(),
            'countries'=>Country::all(),
            'services'=>Service::all()
        ];

        return view('admin.shipments.add-edit', compact('title','type','data','options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'sender_person_id'=>'required',
            'receiver_person_id'=>'required',
            'country_id'=>'required',
            'service_id'=>'required',
            'amount'=>'required|numeric'
        ]);

        $sender_person_id = null;

        if( filter_var($request->sender_person_id, FILTER_VALIDATE_INT) === false ){
            $person = Person::whereRaw('LOWER(first_name) = (?)',[strtolower($request->sender_person_id)])->get();
            if($person->count() > 0){
                $sender_person_id = $person[0]->id;
            }else{
                $person = new Person();
                $person->first_name = ucwords($request->sender_person_id);
                $person->user_id = Auth::user()->id;
                $person->save();
                $sender_person_id = $person->id;
            }
        }else{
            $sender_person_id = $request->sender_person_id;
        }

        $element = Shipment::findorfail($id);
        $element->sender_person_id = $sender_person_id;
        $element->receiver_person_id = $request->receiver_person_id;
        $element->country_id = $request->country_id;
        $element->service_id = $request->service_id;
        $element->amount = $request->amount;

        if($element->update()){
            Session::flash('success', 'Record Update Successfully!!');
        }else{
            Session::flash('error', 'Error Updating The Record!!');
        }

        return redirect()->route('shipments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $element = Shipment::findorfail($id);
        if($element->delete()){
            Session::flash('success', 'Record Deleted Successfully!!');
        }else{
            Session::flash('error', 'Error Deleting The Record!!');
        }

        return redirect()->route('shipments.index');
    }
}
