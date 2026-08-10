<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminSetupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\PatientController;
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
    Route::get('/department', 'department')->name('public.department');
    Route::get('/department-single', 'departmentSingle')->name('public.department-single');
    Route::get('/doctor', 'doctor')->name('public.doctor');
    Route::get('/doctor-single', 'doctorSingle')->name('public.doctor-single');
    Route::get('/blog-sidebar', 'blogSidebar')->name('public.blog-sidebar');
    Route::get('/blog-single', 'blogSingle')->name('public.blog-single');

    // Route động cho các trang Chuyên khoa
    Route::get('/specializations/{slug}', 'specializationSingle')->name('public.specialization.single');
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
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

    // Quản lý Blog của Bác sĩ
    Route::get('/blog', [DoctorController::class, 'blogIndex'])->name('blog.index');
    Route::get('/blog/create', [DoctorController::class, 'createBlog'])->name('blog.create');
    Route::get('/blog/{id}/edit', [DoctorController::class, 'editBlog'])->name('blog.edit');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role = 1)
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Quản lý Tài khoản (Users & Doctors)
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');             // admin.users.index (/admin/users)
        Route::get('/index', 'index');                       // Hỗ trợ thêm cho URL /admin/users/index
        Route::get('/create', 'create')->name('create');     // admin.users.create
        Route::post('/', 'store')->name('store');           // admin.users.store

        // Bổ sung Route sửa tài khoản (nếu cần)
        Route::get('/{id}/edit', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');

        // Ràng buộc id BẮT BUỘC phải là chữ số -> Không bị đụng độ với chữ "index"
        Route::delete('/{id}', 'destroy')->name('destroy')->whereNumber('id');
    });

    // 3. Quản lý Bài viết / Blog
    Route::controller(BlogController::class)->prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/create', 'create')->name('create');     // admin.blogs.create
        Route::post('/', 'store')->name('store');           // admin.blogs.store
    });

    // 4. Quản lý Hồ sơ cá nhân Admin
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', 'edit')->name('edit');          // admin.profile.edit
        Route::put('/', 'update')->name('update');          // admin.profile.update
    });
});
