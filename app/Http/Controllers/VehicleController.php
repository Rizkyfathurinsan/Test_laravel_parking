<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Exports\VehiclesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{

    public function index(User $user)
    {
      $user = new User;
      return view('vehicles.index',
      ['vehicles' =>
      Vehicle::with(['user:id,name'])->get()]);
    
    }

    public function export() 
    {
        return Excel::download(new VehiclesExport, 'report.xlsx');
    }


    public function create()
    {
        return view('vehicles.create');
    }


    public function store(StoreVehicleRequest $request)
    {
      try {
        Vehicle::updateOrCreate(['id' => $request->vehicle_id], $request->except('vehicle_id', 'status') + ['status' => 1]);
        return redirect()->route('vehicles.index')->with('success',  $request->vehicle_id ? 'Vehicle Updated Successfully!!' : 'Vehicle Created Successfully!!');
      } catch (\Throwable $th) {
        return redirect()->route('vehicles.create')->with('error', 'Vehicle Cannot be Create please check the inputs!!');
      }
    }

    public function show(Vehicle $vehicle)
    {
        //
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
      
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle Deleted Successfully!!');

    }

    public function exit(Vehicle $vehicle)
    {
      $vehicle->status = 0;
      $vehicle->save(); 
      return redirect()->route('vehicles.index')->with('success', 'Vehicle exited!!');


    }


}
