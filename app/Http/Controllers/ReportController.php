<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Person;
use App\Models\Service;

use App\Exports\ShipmentExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function reports_movements(Request $request){

        $from = "";
        $to = "";
        $sender = -1;
        $service = "";

        $title = "Movement Report";
        $data = [
            'persons'=>Person::all(),
            'services'=>Service::all()
        ];

        $filter = $request->get('filter');

        $shipments = Shipment::with('sender','country','service');

        if(!empty($filter)){

            $from = $request->get('from');
            $to = $request->get('to');

            if(!empty($from) and !empty($to)){
                $shipments->where('shipments.shipment_date','>=',$from)->where('shipments.shipment_date','<=',$to);
            }

            $sender = $request->get('sender');

            if(!empty($sender)){
                $shipments->where('shipments.sender_person_id',$sender);
            }

            $service = $request->get('service');

            if(!empty($service)){
                $shipments->where('shipments.service_id',$service);
            }
        }

        $result = $shipments->orderBy('shipment_date','DESC')->get();

        return view('admin.reports.movements', compact('title','data','from','to','sender','service','result'));
    }

    public function export_movements(Request $request) 
    {

        $shipments = Shipment::with('sender','country','service');

        $from = @$request->get('from');
        $to = @$request->get('to');

        if(!empty($from) and !empty($to)){
            $shipments->where('shipments.shipment_date','>=',$from)->where('shipments.shipment_date','<=',$to);
        }

        $sender = @$request->get('sender');

        if(!empty($sender)){
            $shipments->where('shipments.sender_person_id',$sender);
        }

        $service = @$request->get('service');

        if(!empty($service)){
            $shipments->where('shipments.service_id',$service);
        }

        $result = $shipments->orderBy('shipment_date','DESC')->get();

        return Excel::download(new ShipmentExport($result), 'movements.xlsx');
    }
}