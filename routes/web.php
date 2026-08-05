<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index']);
Route::get('/about', [FrontendController::class, 'about']);
Route::get('/service', [FrontendController::class, 'service']);
Route::get('/department', [FrontendController::class, 'department']);
Route::get('/department-single', [FrontendController::class, 'departmentSingle']);
Route::get('/doctor', [FrontendController::class, 'doctor']);
Route::get('/doctor-single', [FrontendController::class, 'doctorSingle']);
Route::get('/appointment', [FrontendController::class, 'appointment']);
Route::get('/confirmation', [FrontendController::class, 'confirmation']);
Route::get('/blog-sidebar', [FrontendController::class, 'blogSidebar']);
Route::get('/blog-single', [FrontendController::class, 'blogSingle']);
Route::get('/contact', [FrontendController::class, 'contact']);
Route::get('/login', [FrontendController::class, 'login']);
Route::get('/register', [FrontendController::class, 'register']);
Route::get('/doctor/login', [FrontendController::class, 'doctorLogin']);
Route::get('/doctor/dashboard', [FrontendController::class, 'doctorDashboard']);

