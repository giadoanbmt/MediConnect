<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Thống kê dữ liệu từ CSDL
        $totalPatients = DB::table('AccountUser')
            ->where('Role', 2)
            ->whereNull('DeletedAt')
            ->count();

        $totalDoctors = DB::table('Doctor')
            ->whereNull('DeletedAt')
            ->count();

        $totalAppointments = DB::table('Appointment')->count();

        // Đã sửa tên bảng từ Content -> News
        $totalArticles = DB::table('News')
            ->whereNull('DeletedAt')
            ->count();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalAppointments',
            'totalArticles'
        ));
    }
}
