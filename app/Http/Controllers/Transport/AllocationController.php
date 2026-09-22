<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\TransportAllocation;
use App\Models\TransportRoute;
use App\Models\Student;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index()
    {
        $allocations = TransportAllocation::with(['student.user', 'route'])->get();
        $routes = TransportRoute::all();
        $students = Student::with('user')->get();
        return view('transport.allocations.index', compact('allocations', 'routes', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id|unique:transport_allocations,student_id',
            'transport_route_id' => 'required|exists:transport_routes,id',
        ], [
            'student_id.unique' => 'This student is already allocated to a route.',
        ]);

        TransportAllocation::create($validated);

        return redirect()->route('transport.allocations.index')->with('success', 'Student allocated to route successfully.');
    }

    public function destroy($id)
    {
        $allocation = TransportAllocation::findOrFail($id);
        $allocation->delete();
        return redirect()->route('transport.allocations.index')->with('success', 'Allocation removed.');
    }
}
