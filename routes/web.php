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
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
