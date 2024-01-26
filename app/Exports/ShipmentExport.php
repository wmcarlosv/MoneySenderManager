<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\StoreInfo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShipmentExport implements FromView
{

    public $data;

    public function __construct($data){
        $this->data = $data;
    }
    public function view(): View
    {
        $store = StoreInfo::first();
        if(!$store){
            $store = [];
        }
        return view('admin.reports.excels.movements', [
            'data' => $this->data,
            'store'=>$store
        ]);
    }
}
