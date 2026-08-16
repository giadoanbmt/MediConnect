<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountUser;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = trim($validated['username']);

        // 1. Kiểm tra tài khoản trong bảng AccountUser (Admin & Patient)
        $accountUser = AccountUser::query()
            ->where(function ($query) use ($loginValue): void {
                $query->where('Username', $loginValue)
                    ->orWhere('Email', $loginValue);
            })
            ->first();

        if ($accountUser) {
            // Kiểm tra mật khẩu (Hỗ trợ cả Hash và Plain Text cũ)
            $passwordCorrect = password_get_info($accountUser->Password)['algo'] !== 0
                ? Hash::check($validated['password'], $accountUser->Password)
                : $accountUser->Password === $validated['password'];

            if (! $passwordCorrect) {
                return back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['password' => 'Password is incorrect.']);
            }

            // Tự động Hash lại mật khẩu cũ nếu phát hiện là Plain Text
            if (password_get_info($accountUser->Password)['algo'] === 0) {
                $accountUser->Password = Hash::make($validated['password']);
            }

            // Cập nhật trạng thái Hoạt động (Online = 1) khi đăng nhập thành công
            $accountUser->IsActive = 1;
            $accountUser->save();

            Auth::loginUsingId($accountUser->getKey());
            $request->session()->regenerate();

            $role = (int) $accountUser->Role;

            // Role 1: Admin -> Vào Admin Dashboard, Role 2: Patient -> Vào Trang chủ
            if ($role === 1) {
                return redirect('/admin/dashboard');
            }

            return redirect()->route('public.home');
        }

        // 2. Nếu không có trong AccountUser, kiểm tra trong bảng Doctor (Bác sĩ)
        $doctor = Doctor::query()
            ->where('Username', $loginValue)
            ->orWhere('Email', $loginValue)
            ->first();

        if (! $doctor) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Account does not exist in the system.']);
        }

        // Kiểm tra mật khẩu Doctor
        $passwordCorrect = password_get_info($doctor->Password)['algo'] !== 0
            ? Hash::check($validated['password'], $doctor->Password)
            : $doctor->Password === $validated['password'];

        if (! $passwordCorrect) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['password' => 'Password is incorrect.']);
        }

        // Tự động Hash lại mật khẩu Doctor nếu là Plain Text
        if (password_get_info($doctor->Password)['algo'] === 0) {
            $doctor->Password = Hash::make($validated['password']);
            $doctor->save();
        }

        // Lưu Session dành riêng cho Doctor
        $request->session()->put([
            'auth_type' => 'doctor',
            'doctor_id' => $doctor->DoctorId,
            'doctor_name' => $doctor->FullName, // Đã sửa tên cột thành FullName
        ]);

        $request->session()->regenerate();

        return redirect('/doctor/dashboard');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('AccountUser', 'Username')
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('AccountUser', 'Email')
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
        ]);

        // Đăng ký người dùng mới và tự động kích hoạt trạng thái Online (IsActive = 1) do thực hiện tự động đăng nhập ngay sau đó
        $user = AccountUser::create([
            'FullName' => $validated['name'],
            'Username' => $validated['username'],
            'Email' => $validated['email'],
            'Password' => Hash::make($validated['password']),
            'Role' => 2, // 2: Patient (Bệnh nhân)
            'IsActive' => 1,
        ]);

        Auth::loginUsingId($user->getKey());
        $request->session()->regenerate();

        return redirect()->route('public.home');
    }

    public function logout(Request $request): RedirectResponse
    {
        // Đăng xuất cho Bác sĩ
        if (
            $request->session()->has('auth_type')
            && $request->session()->get('auth_type') === 'doctor'
        ) {
            $request->session()->forget([
                'auth_type',
                'doctor_id',
                'doctor_name',
            ]);

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')
                ->with('status', 'Logout successful. You have been logged out.');
        }

        // Đăng xuất cho Admin & Patient: Chuyển IsActive về 0 (Offline)
        if (Auth::check()) {
            AccountUser::where('UserId', Auth::id())->update(['IsActive' => 0]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home')
            ->with('status', 'Logout successful. You have been logged out.');
    }
}
