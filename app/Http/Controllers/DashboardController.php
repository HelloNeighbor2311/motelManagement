<?php

namespace App\Http\Controllers;

use App\Models\CanHo;
use App\Models\KhuVuc;
use App\Models\ToaNha;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $statusCounts = CanHo::forCurrentUser()
            ->selectRaw('TrangThai, COUNT(*) as total')
            ->groupBy('TrangThai')
            ->pluck('total', 'TrangThai');

        $totalApartments = (int) $statusCounts->sum();
        $occupiedApartments = (int) ($statusCounts['DangThue'] ?? 0);

        $stats = [
            'areas' => KhuVuc::forCurrentUser()->count(),
            'buildings' => ToaNha::forCurrentUser()->count(),
            'apartments' => $totalApartments,
            'empty' => (int) ($statusCounts['Trong'] ?? 0),
            'occupied' => $occupiedApartments,
            'maintenance' => (int) ($statusCounts['BaoTri'] ?? 0),
            'occupancyRate' => $totalApartments > 0 ? round(($occupiedApartments / $totalApartments) * 100, 1) : 0,
        ];

        $areas = KhuVuc::forCurrentUser()->withCount(['toaNhas as toaNhas_count'])
            ->orderBy('TenKhuVuc')
            ->get();

        $recentApartments = CanHo::forCurrentUser()->with('toaNha.khuVuc')
            ->orderByDesc('CreatedAt')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact('stats', 'areas', 'recentApartments'));
    }
}
