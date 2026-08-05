<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function dashboard(): View
    {
        return view('doctor.dashboard');
    }
}
