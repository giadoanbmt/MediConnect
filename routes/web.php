<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;

/* Public: anyone can browse, but cannot submit contact or book appointments. */

Route::controller(PatientController::class)->group(function () {
    Route::get('/', 'index')->name('public.home');
    Route::get('/about', 'about')->name('public.about');
    Route::get('/service', 'service')->name('public.service');
    Route::get('/department', 'department')->name('public.department');
    Route::get('/department-single', 'departmentSingle')->name('public.department-single');
    Route::get('/doctor', 'doctor')->name('public.doctor');
    Route::get('/doctor-single', 'doctorSingle')->name('public.doctor-single');
    Route::get('/blog-sidebar', 'blogSidebar')->name('public.blog-sidebar');
    Route::get('/blog-single', 'blogSingle')->name('public.blog-single');
});

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('role:patient,admin,doctor')->name('logout');

/* Patient: pages and actions that require a signed-in patient. */
Route::middleware('role:patient')->group(function () {
    Route::controller(PatientController::class)->group(function () {
        Route::get('/appointment', 'appointment')->name('patient.appointment');
        Route::get('/confirmation', 'confirmation')->name('patient.confirmation');
        Route::get('/contact', 'contact')->name('patient.contact');
    });

    Route::get('/doctors', [DoctorController::class, 'index'])->name('patient.doctors.index');
    Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('patient.doctors.show');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('patient.appointments.index');
    Route::post('/appointments/{id}/book', [AppointmentController::class, 'book'])->name('patient.appointments.book');
    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])->name('patient.appointments.reschedule');
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');
});

Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])
    ->middleware('role:doctor')
    ->name('doctor.dashboard');
