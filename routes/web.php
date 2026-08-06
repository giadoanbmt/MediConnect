<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index']);
Route::get('/about', [FrontendController::class, 'about']);
Route::get('/service', [FrontendController::class, 'service']);
Route::get('/specialization', [FrontendController::class, 'specialization']);
Route::get('/specialization-single', [FrontendController::class, 'specializationSingle']);
Route::get('/doctor', [FrontendController::class, 'doctor']);
Route::get('/doctor-single', [FrontendController::class, 'doctorSingle']);
Route::get('/appointment', [FrontendController::class, 'appointment']);
Route::get('/confirmation', [FrontendController::class, 'confirmation']);
Route::get('/blog-sidebar', [FrontendController::class, 'blogSidebar']);
Route::get('/blog-single', [FrontendController::class, 'blogSingle']);
Route::get('/contact', [FrontendController::class, 'contact']);
Route::get('/login', [FrontendController::class, 'login']);
Route::get('/register', [FrontendController::class, 'register']);
