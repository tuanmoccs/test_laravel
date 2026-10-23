<?php

namespace App\Http\Controllers;

use App\Models\Location;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Location::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('index', [
            'total' => $stats->sum(),
            'stats' => $stats,
        ]);
    }
}
