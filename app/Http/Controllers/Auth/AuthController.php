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

        $accountUser = AccountUser::query()
            ->where(function ($query) use ($loginValue): void {
                $query->where('Username', $loginValue)
                    ->orWhere('Email', $loginValue);
            })
            ->first();

        if ($accountUser) {
            if ((int) $accountUser->Role === 0 || (int) $accountUser->Role === 3) {
                return back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['username' => 'This account cannot log in here.']);
            }

            if (! (bool) $accountUser->IsActive) {
                return back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['username' => 'This account is inactive.']);
            }

            /*
             * Kiểm tra password.
             *
             * Password mới: đã được Hash::make()
             * Password cũ: vẫn có thể đang là plain text
             */
            $passwordCorrect = false;

            if (password_get_info($accountUser->Password)['algo'] !== 0) {
                // Password đã được hash
                $passwordCorrect = Hash::check(
                    $validated['password'],
                    $accountUser->Password
                );
            } else {
                // Password cũ đang là plain text
                $passwordCorrect = $accountUser->Password === $validated['password'];
            }

            if (! $passwordCorrect) {
                return back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['password' => 'Incorrect password']);
            }

            /*
             * Nếu password cũ là plain text,
             * tự động hash lại sau khi đăng nhập thành công.
             */
            if (password_get_info($accountUser->Password)['algo'] === 0) {
                $accountUser->Password = Hash::make($validated['password']);
                $accountUser->save();
            }

            Auth::loginUsingId($accountUser->getKey());
            $request->session()->regenerate();

            $role = (int) $accountUser->Role;

            if ($role === 1) {
                return redirect('/admin/dashboard');
            }

            return redirect()->route('public.home');
        }

        $doctor = Doctor::query()
            ->where('DoctorAccount', $loginValue)
            ->first();

        if (! $doctor) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Account not found']);
        }

        /*
         * Kiểm tra password Doctor.
         * Hỗ trợ cả password đã hash và password plain text cũ.
         */
        $passwordCorrect = false;

        if (password_get_info($doctor->Password)['algo'] !== 0) {
            // Password đã được hash
            $passwordCorrect = Hash::check(
                $validated['password'],
                $doctor->Password
            );
        } else {
            // Password cũ đang là plain text
            $passwordCorrect = $doctor->Password === $validated['password'];
        }

        if (! $passwordCorrect) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['password' => 'Incorrect password']);
        }

        /*
         * Nếu Doctor vẫn đang dùng password plain text,
         * tự động hash lại sau lần đăng nhập thành công.
         */
        if (password_get_info($doctor->Password)['algo'] === 0) {
            $doctor->Password = Hash::make($validated['password']);
            $doctor->save();
        }

        $request->session()->put([
            'auth_type' => 'doctor',
            'doctor_id' => $doctor->DoctorId,
            'doctor_name' => $doctor->DoctorName,
        ]);

        $request->session()->regenerate();

        return redirect('/doctor/dashboard');
    }


    public function register(Request $request): RedirectResponse
    {
        // 1. Kiểm tra & Validate dữ liệu đầu vào
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'gender'   => ['nullable', 'string', 'max:10'],
            'username' => ['required', 'string', 'max:50', 'unique:AccountUser,Username'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:AccountUser,Email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'], // Yêu cầu nhập password_confirmation
            'address'  => ['required', 'string', 'max:255'],
        ], [
            // Custom thông báo lỗi 
            'name.required'       => 'Please enter your full name.',
            'username.required'   => 'Please enter a username.',
            'username.unique'     => 'This username is already taken.',
            'email.required'      => 'Please enter your email address.',
            'email.email'         => 'Please enter a valid email address.',
            'email.unique'        => 'This email address is already registered.',
            'password.required'   => 'Please enter a password.',
            'password.min'        => 'Password must be at least 6 characters.',
            'password.confirmed'  => 'Password confirmation does not match.',
            'address.required'   => 'Please enter your address.',
        ]);

        // 2. Tạo User mới trong Database
        $user = AccountUser::create([
            'FullName' => $request->name,     // Đổi thành 'name' nếu tên cột DB của bạn là 'name'
            'Gender'   => $request->gender,
            'Username' => $request->username,
            'Email'    => $request->email,
            'Password' => Hash::make($request->password), // Mã hóa mật khẩu
            'Address'  => $request->address,
            // 'role'  => 'patient', // Gán quyền mặc định nếu hệ thống MediConnect có chia role
        ]);

        // 3. Tự động đăng nhập cho User mới tạo
        Auth::login($user);

        // 4. Chuyển hướng về trang chủ kèm thông báo thành công
        return redirect()->route('public.home')->with('success', 'Registration successful! Welcome to MediConnect.');
    }


    public function logout(Request $request): RedirectResponse
    {
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
                ->with('status', 'Successfully logged out.');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home')
            ->with('status', 'Successfully logged out.');
    }
}
