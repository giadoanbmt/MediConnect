<?php

//use Amdin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

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
Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])
        ->name('dashboard');

    // Quản lý hồ sơ bác sĩ
    Route::get('/profile', [DoctorController::class, 'profile'])
        ->name('profile');

    Route::put('/profile', [DoctorController::class, 'updateProfile'])
        ->name('profile.update');
    // Quản lý Blog của Bác sĩ
    Route::get('/blog', [DoctorController::class, 'blogIndex'])
        ->name('blog.index');

    Route::get('/blog/create', [DoctorController::class, 'createBlog'])
        ->name('blog.create');

    Route::get('/blog/{id}/edit', [DoctorController::class, 'editBlog'])
        ->name('blog.edit');
});
/*
|--------------------------------------------------------------------------
| Admin Routes (Role = 1)
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard Admin (Đang dùng AdminController để lấy dữ liệu thống kê)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Quản lý Tài khoản (Users & Doctors)
    // 2.1. Quản lý Bệnh nhân (Patients)
    Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');             // admin.users.index
        Route::get('/create', 'create')->name('create');     // admin.users.create
        Route::post('/', 'store')->name('store');           // admin.users.store
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 2.2. Quản lý Bác sĩ (Doctors)
    Route::controller(AdminDoctorController::class)->prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', 'index')->name('index');             // admin.doctors.index
        Route::get('/create', 'create')->name('create');     // admin.doctors.create
        Route::post('/', 'store')->name('store');           // admin.doctors.store
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 3. Quản lý Tin tức / Bài viết (News - Đã đổi tên từ Blog)
    Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
        Route::get('/', 'index')->name('index');             // admin.news.index (/admin/news)
        Route::get('/create', 'create')->name('create');     // admin.news.create
        Route::post('/', 'store')->name('store');           // admin.news.store
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');     // admin.news.edit
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');     // admin.news.update
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id'); // admin.news.destroy
    });

    // 4. Quản lý Hồ sơ cá nhân Admin
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', 'edit')->name('edit');          // admin.profile.edit
        Route::put('/', 'update')->name('update');          // admin.profile.update
    });

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{id}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{id}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
});

// 5. Quản lý ContactQuery
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Trang danh sách câu hỏi
    Route::get('/contact-queries', [AdminContactController::class, 'index'])->name('admin.contact.index');

    // Trang xem chi tiết / form phản hồi
    Route::get('/contact-queries/{id}', [AdminContactController::class, 'show'])->name('admin.contact.show');

    // Action lưu phản hồi / cập nhật trạng thái
    Route::put('/contact-queries/{id}/respond', [AdminContactController::class, 'respond'])->name('admin.contact.respond');
});
