<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
       $vehicles  = new Vehicle();
       $duration = [];
       foreach ($vehicles->get() as $key => $vehicle) {
        $diff = Carbon::parse($vehicle->created_at)->diffInHours(Carbon::now());
        
        $duration[] =  $diff * 3000;
       }

       $total_amount = array_sum($duration);
       $total_vehicles = $vehicles->count();
       $total_vehicle_in = $vehicles->where('status',1)->orWhere('status', 1)->whereDate('created_at', now()->format('Y-m-d'))->count();
       $total_vehicle_out = $vehicles->where('status',0)->whereDate('created_at', now()->format('Y-m-d'))->count();

        return view('home', ['vehicles' => $vehicles->get()] ,compact('total_amount', 'total_vehicle_in', 'total_vehicle_out','total_vehicles'));
    }
}
