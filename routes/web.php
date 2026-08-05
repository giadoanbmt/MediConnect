<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PatientController::class, 'index']);
Route::get('/about', [PatientController::class, 'about']);
Route::get('/service', [PatientController::class, 'service']);
Route::get('/department', [PatientController::class, 'department']);
Route::get('/department-single', [PatientController::class, 'departmentSingle']);
Route::get('/doctor', [PatientController::class, 'doctor']);
Route::get('/doctor-single', [PatientController::class, 'doctorSingle']);
Route::get('/appointment', [PatientController::class, 'appointment']);
Route::get('/confirmation', [PatientController::class, 'confirmation']);
Route::get('/blog-sidebar', [PatientController::class, 'blogSidebar']);
Route::get('/blog-single', [PatientController::class, 'blogSingle']);
Route::get('/contact', [PatientController::class, 'contact']);
use App\Http\Controllers\Patient\AuthController as PatientAuthController;
use App\Http\Controllers\Patient\DoctorController as PatientDoctorController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
// Giao diện Đăng nhập & Đăng ký
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [PatientAuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [PatientAuthController::class, 'register']);



// Routes Phân hệ Bệnh nhân
    Route::post('/logout', [PatientAuthController::class, 'logout']);
    
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});
    // Tra cứu Bác sĩ
    Route::get('/doctors', [PatientDoctorController::class, 'index']);
    Route::get('/doctors/{id}', [PatientDoctorController::class, 'show']);

    // Quản lý lịch hẹn
    Route::middleware('auth')->group(function () {
        Route::get('/appointments', [PatientAppointmentController::class, 'index']);
        Route::post('/appointments/{id}/book', [PatientAppointmentController::class, 'book']);
        Route::put('/appointments/{id}/reschedule', [PatientAppointmentController::class, 'reschedule']);
        Route::delete('/appointments/{id}/cancel', [PatientAppointmentController::class, 'cancel']);
    });