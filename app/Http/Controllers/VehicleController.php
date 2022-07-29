<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\User;
use App\Exports\VehiclesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            Vehicle::updateOrCreate(['id' => $request->vehicle_id], $request->except('vehicle_id', 'status') + ['status' => 1]);
            return redirect()->route('vehicles.index')->with('success',  $request->vehicle_id ? 'Vehicle Updated Successfully!!' : 'Vehicle Created Successfully!!');
          } catch (\Throwable $th) {
            return redirect()->route('vehicles.create')->with('error', 'Vehicle Cannot be Create please check the inputs!!');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->update(['status' => 0]);
        return redirect()->route('vehicles.index')->with('success', 'Vehicle exited!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleRequest  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle Deleted Successfully!!');
    }

    public function exit(Vehicle $vehicle)
    {
      $vehicle->update(['status' => false]);

      if($vehicle->status == true)
      {
        return redirect()->route('vehicles.index')->with('error', 'Vehicle Cannot exit please check the inputs!!');
      } 
      else
      {
        return redirect()->route('vehicles.index')->with('success', 'Vehicle exited!!');
      }

    }
}
