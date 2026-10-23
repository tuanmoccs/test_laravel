<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return view('locations.index');
    }

    public function create()
    {
        return view('locations.create', ['location' => new Location]);
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->validated());

        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Request $request, Location $location)
    {
        $location->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Location deleted successfully.']);
        }

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}
