<?php

//use Amdin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\SpecializationController as AdminSpecializationController;
use App\Http\Controllers\Admin\CityController as AdminCityController;


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


Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/specialization-single/{id}', 'specializationSingle')->name('public.specialization-single');
    Route::get('/doctor', 'Doctor')->name('public.doctor');
    Route::get('/doctor-profile/{id}', 'doctorProfile')->name('public.doctorProfile');
    Route::get('/blog-sidebar', 'blogSidebar')->name('public.blog-sidebar');
    Route::get('/blog-single/{id}', 'blogSingle')->name('public.blog-single');
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
Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {

    Route::controller(PatientController::class)->group(function () {
        Route::get('/appointment', 'appointment')->name('appointment');
        Route::get('/confirmation', 'confirmation')->name('confirmation');
        Route::get('/contact', 'contact')->name('contact');

        // Quản lý Profile Bệnh nhân
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile', 'updateProfile')->name('profile.update');
    });

    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');

    // Quản lý Đặt lịch khám
    Route::get('/my-appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointment/book', [AppointmentController::class, 'create'])->name('appointments.book');
    Route::post('/appointment/book', [AppointmentController::class, 'store'])->name('appointments.store');

    // AJAX Get data
    Route::get('/appointments/get-doctors', [AppointmentController::class, 'getDoctorsBySpecialization'])->name('appointments.get-doctors');
    Route::get('/appointments/get-slots', [AppointmentController::class, 'getSlots'])->name('appointments.get-slots');

    // Đổi lịch & Hủy lịch
    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

/*
|--------------------------------------------------------------------------
| Doctor Routes (Auth Session)
|--------------------------------------------------------------------------
*/
Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])
        ->name('dashboard');
    Route::post('/notifications/read', [DoctorController::class, 'markNotificationsRead'])
        ->name('notifications.read');


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

    Route::get('/news/{id}', [DoctorController::class, 'showNews'])
        ->name('news.show');

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
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Quản lý Lịch hẹn (Appointments)
    Route::controller(AdminAppointmentController::class)->prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', 'index')->name('index'); // admin.appointments.index
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
        Route::get('/get-rooms/{specializationId}', 'getRoomsBySpecialization')->name('get-rooms');
        Route::get('/get-districts/{cityName}', 'getDistrictsByCity')->name('get-districts');
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

    // 8. Quản lý Chuyên khoa & Phòng khám
    Route::controller(AdminSpecializationController::class)->prefix('specializations')->name('specializations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/add-room', 'addRoom')->name('addRoom');
        Route::delete('/room/{roomId}', 'destroyRoom')->name('destroyRoom');
    });

    // 9. Quản lý Thành phố & Quận/Huyện
    Route::controller(AdminCityController::class)->prefix('cities')->name('cities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/add-district', 'addDistrict')->name('addDistrict');
        Route::delete('/district/{districtId}', 'destroyDistrict')->name('destroyDistrict');
    });
});
