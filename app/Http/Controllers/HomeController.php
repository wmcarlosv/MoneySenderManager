<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Country;
use App\Models\Person;
use App\Models\Shipment;

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
        return view('admin.dashboard', compact('data'));
    }
}
