<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter waktu
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Query dengan join
        $reports = DB::table('checkouts')
            ->join('motors', 'checkouts.motor_id', '=', 'motors.id')
            ->select(
                'motors.id as motor_id',
                'motors.name as motor_name',
                DB::raw('SUM(motors.price) as total_pendapatan'),
                DB::raw('COUNT(checkouts.id) as total_penjualan')
            )
            ->whereBetween('checkouts.created_at', [$startDate, $endDate])
            ->groupBy('motors.id', 'motors.name')
            ->get();

        // Hitung total pendapatan dan total penjualan
        $totalPendapatan = $reports->sum('total_pendapatan');
        $totalPenjualan = $reports->sum('total_penjualan');

        return view('admin.report', compact('reports', 'startDate', 'endDate', 'totalPendapatan', 'totalPenjualan'));
    }

}
