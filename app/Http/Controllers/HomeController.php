<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Country;
use App\Models\Person;
use App\Models\Shipment;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = (object) [
            'services'=>Service::all()->count(),
            'countries'=>Country::all()->count(),
            'persons'=>Person::all()->count(),
            'shipments'=>Shipment::all()->count()
        ];

        $date_from = date('Y-m')."-01";
        $date_to = date('Y-m-d');

        $profiles = DB::select("select 
                    sender.first_name as send,
                    service.name as serv,
                    service.monthly_limit_amount as lmit,
                    sum(ship.amount) as amount,
                    (sum(ship.amount) - service.monthly_limit_amount) as difference
                    from shipments as ship
                    inner join persons as sender on ship.sender_person_id = sender.id
                    inner join services as service on (service.id = ship.service_id)
                    where shipment_date BETWEEN '".$date_from."' and '".$date_to."'
                    group by sender.first_name, service.name, service.monthly_limit_amount
                    HAVING amount > service.monthly_limit_amount");

        return view('admin.dashboard', compact('data','profiles'));
    }
}
