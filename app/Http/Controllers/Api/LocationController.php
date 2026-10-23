<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private const SORTABLE = ['id', 'name', 'lat', 'lng', 'status', 'created_at'];

    public function index(Request $request)
    {
        $query = Location::query();
        $total = (clone $query)->count();

        if ($keyword = $request->input('search.value')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('status', 'like', "%{$keyword}%")
                    ->orWhere('lat', 'like', "%{$keyword}%")
                    ->orWhere('lng', 'like', "%{$keyword}%");
            });
        }

        $filtered = (clone $query)->count();

        $column = $request->input('columns.'.(int) $request->input('order.0.column', 0).'.data', 'id');
        $direction = $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc';
        $query->orderBy(in_array($column, self::SORTABLE, true) ? $column : 'id', $direction);

        $length = (int) $request->input('length', 10);
        $length = $length > 0 ? min($length, 100) : 10;

        $data = $query->skip(max((int) $request->input('start', 0), 0))
            ->take($length)
            ->get()
            ->map(fn (Location $location) => [
                'id' => $location->id,
                'name' => $location->name,
                'lat' => $location->lat,
                'lng' => $location->lng,
                'status' => $location->status,
                'created_at' => $location->created_at?->format('Y-m-d H:i'),
                'edit_url' => route('locations.edit', $location),
                'delete_url' => route('locations.destroy', $location),
            ]);

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }
}
