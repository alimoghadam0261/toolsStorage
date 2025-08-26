<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Storage;

class AuthController extends Controller
{
    // فرم ثبت‌نام
    public function showRegisterForm()
    {
        $storages = Storage::select('id', 'name')->get();
        return view('auth.auth', compact('storages'));
    }

    // ثبت‌نام
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'min:3', 'max:15'],
            'mobile'     => ['required', 'numeric', 'regex:/^0\d{10}$/', 'unique:users'],
            'cardNumber' => ['required', 'string', 'min:3', 'max:6', 'unique:users'],
            'department' => ['required'],
            'role'       => ['required'],
            'storage'    => ['required'],
        ]);

        // هش کردن موبایل برای رمز عبور
        $data['mobile'] = Hash::make($data['mobile']);

        User::create($data);

        return redirect()->back()->with('success', 'کاربر جدید با موفقیت ثبت شد ✅');
    }

    // فرم ورود
    public function showLoginForm()
    {
        $storages = Storage::select('id', 'name')->get();
        return view('auth.auth', compact('storages'));
    }

    // ورود
    public function login(Request $request)
    {
        $data = $request->validate([
            'cardNumber' => ['required', 'string', 'min:3', 'max:6'],
            'mobile'     => ['required', 'numeric', 'regex:/^0\d{10}$/'],
        ]);

        $user = User::where('cardNumber', $data['cardNumber'])->first();

        if (!$user || !Hash::check($data['mobile'], $user->mobile)) {
            return back()->withErrors([
                'credentials' => 'همکار گرامی ، شماره پرسنلی یا رمز عبور اشتباه می‌باشد'
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // هدایت بر اساس نقش
    protected function redirectBasedOnRole(User $user)
    {
        $role = $user->role;

        if ($role === 'admin' || $role === 'author') {
            return redirect()->route('admin.dashboard');
        }

        // پیش‌فرض کاربر عادی
        return redirect()->route('home');
    }

    // خروج
    public function logout(Request $request)
    {
        Auth::logout();

        // حذف session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    // حذف نرم
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'کاربر با موفقیت حذف شد.');
    }

    // بازیابی کاربر حذف‌شده
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'کاربر با موفقیت بازیابی شد.');
    }

    // حذف کامل
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->back()->with('success', 'کاربر به طور کامل حذف شد.');
    }
}
