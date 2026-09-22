<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('transport.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('transport.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|unique:vehicles,vehicle_number|max:255',
            'driver_name' => 'required|max:255',
            'driver_phone' => 'required|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Vehicle::create($validated);

        return redirect()->route('transport.vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('transport.vehicles.index')->with('success', 'Vehicle deleted.');
    }
}
