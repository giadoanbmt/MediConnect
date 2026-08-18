<?php

//use Amdin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

// Auth
use App\Http\Controllers\Auth\AdminSetupController;
use App\Http\Controllers\Auth\AuthController;

//use Doctor
use App\Http\Controllers\Doctor\DoctorController;

//use Patient
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ContactController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::controller(PatientController::class)->group(function () {
    Route::get('/', 'index')->name('public.home');
    Route::get('/about', 'about')->name('public.about');
    Route::get('/service', 'service')->name('public.service');
    Route::get('/specialization', 'specialization')->name('public.specialization');
    Route::get('/doctor', 'Doctor')->name('public.doctor');
    Route::get('/doctor-profile/{id}', 'doctorProfile')->name('public.doctorProfile');
    Route::get('/blog-sidebar', 'blogSidebar')->name('public.blog-sidebar');
    Route::get('/blog-single', 'blogSingle')->name('public.blog-single');

    // Route động cho các trang Chuyên khoa
    Route::get('/specializations/Cardiology', 'specializationCardiology')->name('specializations.Cardiology');
    Route::get('/specializations/Dermatology', 'specializationDermatology')->name('specializations.Dermatology');
    Route::get('/specializations/Orthopedics', 'specializationOrthopedics')->name('specializations.Orthopedics');
    Route::get('/specializations/Pediatrics', 'specializationPediatrics')->name('specializations.Pediatrics');
});

/*
|--------------------------------------------------------------------------
| Guest Routes & One-Time Admin Setup
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Route Đăng ký Admin ban đầu (Chỉ truy cập được khi CSDL CHƯA CÓ Admin)
Route::middleware('no_admin')->group(function () {
    Route::get('/admin/setup-initial', [AdminSetupController::class, 'showRegisterForm'])->name('admin.setup');
    Route::post('/admin/setup-initial', [AdminSetupController::class, 'register'])->name('admin.setup.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('role:patient,admin,doctor')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Patient Routes (Role = 2)
|--------------------------------------------------------------------------
*/


Route::middleware('role:patient')->group(function () {
    Route::controller(PatientController::class)->group(function () {
        Route::get('/appointment', 'appointment')->name('patient.appointment');
        Route::get('/confirmation', 'confirmation')->name('patient.confirmation');
        Route::get('/contact', 'contact')->name('patient.contact');
    });
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('patient.doctors.index');
    Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('patient.doctors.show');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('patient.appointments.index');
    Route::post('/appointments/{id}/book', [AppointmentController::class, 'book'])->name('patient.appointments.book');
    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])->name('patient.appointments.reschedule');
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');
});

/*
|--------------------------------------------------------------------------
| Doctor Routes (Auth Session)
|--------------------------------------------------------------------------
*/
Route::middleware(['role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])
            ->name('dashboard');


        // Quản lý hồ sơ bác sĩ
        Route::get('/profile', [DoctorController::class, 'profile'])
            ->name('profile');

        Route::put('/profile', [DoctorController::class, 'updateProfile'])
            ->name('profile.update');


        // Quản lý News của Bác sĩ
        Route::get('/news', [DoctorController::class, 'newsIndex'])
            ->name('news.index');

        Route::get('/news/create', [DoctorController::class, 'createNews'])
            ->name('news.create');

        Route::get('/news/{id}/edit', [DoctorController::class, 'editNews'])
            ->name('news.edit');

        Route::delete('/news/{id}', [DoctorController::class, 'deleteNews'])
            ->name('news.delete');


        // Store / Update News
        Route::post('/news', [DoctorController::class, 'storeNews'])
            ->name('news.store');

        Route::put('/news/{id}', [DoctorController::class, 'updateNews'])
            ->name('news.update');


        // Quản lý lịch làm việc / khung giờ khám
        Route::get('/availability', [DoctorController::class, 'availability'])
            ->name('availability');

        Route::post('/availability', [DoctorController::class, 'saveAvailability'])
            ->name('availability.save');


        // Quản lý lịch hẹn của Bác sĩ
Route::get('/appointments', [DoctorController::class, 'appointments'])
    ->name('appointments');

Route::post('/appointments/{id}/confirm', [DoctorController::class, 'confirmAppointment'])
    ->name('appointments.confirm');

Route::post('/appointments/{id}/cancel', [DoctorController::class, 'cancelAppointment'])
    ->name('appointments.cancel');

Route::post('/appointments/{id}/complete', [DoctorController::class, 'completeAppointment'])
    ->name('appointments.complete');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes (Role = 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Quản lý Lịch hẹn (Appointments)
    Route::controller(AdminAppointmentController::class)->prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', 'index')->name('index');                        // admin.appointments.index
        Route::post('/{id}/approve', 'approve')->name('approve');        // admin.appointments.approve
        Route::post('/{id}/reject', 'reject')->name('reject');          // admin.appointments.reject
    });

    // 3. Quản lý Bệnh nhân (Patients)
    Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 4. Quản lý Bác sĩ (Doctors)
    Route::controller(AdminDoctorController::class)->prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 5. Quản lý Tin tức (News)
    Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show')->whereNumber('id');
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 6. Quản lý Hồ sơ cá nhân Admin
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });

    // 7. Quản lý Contact Queries
    Route::controller(AdminContactController::class)->prefix('contact-queries')->name('contact.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}/respond', 'respond')->name('respond');
    });
});
