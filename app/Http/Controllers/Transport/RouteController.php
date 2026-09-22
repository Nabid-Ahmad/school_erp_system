<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\TransportRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = TransportRoute::withCount('allocations')->get();
        return view('transport.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('transport.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'start_point' => 'required|max:255',
            'end_point' => 'required|max:255',
            'fare' => 'required|numeric|min:0',
        ]);

        TransportRoute::create($validated);

        return redirect()->route('transport.routes.index')->with('success', 'Route added successfully.');
    }

    public function destroy(TransportRoute $route)
    {
        $route->delete();
        return redirect()->route('transport.routes.index')->with('success', 'Route deleted.');
    }
}
