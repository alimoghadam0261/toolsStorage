<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Storage;
use App\LogsActivity; // ← مطابق مسیر فایل
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use LogsActivity;

    // فرم ثبت‌نام
    public function showRegisterForm()
    {
        $storages = Storage::select('id', 'name')->get();
        return view('auth.auth', compact('storages'));
    }

    // ثبت‌نام کاربر
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'min:3', 'max:25'],
            'mobile'     => ['required', 'numeric', 'regex:/^0\d{10}$/', 'unique:users'],
            'cardNumber' => ['required', 'string', 'min:3', 'max:6', 'unique:users'],
            'department' => ['required'],
            'role'       => ['required'],
            'storage'    => ['required'],
        ]);

        // هش کردن موبایل برای رمز عبور
        $data['mobile'] = Hash::make($data['mobile']);

        $user = User::create($data);

        // ثبت لاگ ایجاد کاربر
        $this->logActivity('create', $user, "ثبت‌نام کاربر جدید: {$user->name}");

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
                'credentials' => 'شماره پرسنلی یا رمز عبور اشتباه می‌باشد'
            ]);
        }

        Auth::login($user);

        // ثبت لاگ ورود
        $this->logActivity('login', $user, "کاربر وارد سیستم شد");

        // بررسی آیا کاربر قصد دسترسی به صفحه خاصی داشته است
        if ($request->session()->has('url.intended')) {
            $redirectUrl = session('url.intended');
            $request->session()->forget('url.intended');
            return redirect($redirectUrl);
        }

        return $this->redirectBasedOnRole($user);
    }

    // هدایت بر اساس نقش
    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
            case 'author':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    // خروج
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->logActivity('logout', $user, "کاربر خارج شد");
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    // حذف نرم کاربر
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $this->logActivity('delete', $user, "حذف نرم کاربر: {$user->name}");

        return redirect()->back()->with('success', 'کاربر با موفقیت حذف شد.');
    }

    // بازیابی کاربر حذف‌شده
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        $this->logActivity('restore', $user, "بازیابی کاربر: {$user->name}");

        return redirect()->back()->with('success', 'کاربر با موفقیت بازیابی شد.');
    }

    // حذف کامل کاربر
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        $this->logActivity('force_delete', $user, "حذف کامل کاربر: {$user->name}");

        return redirect()->back()->with('success', 'کاربر به طور کامل حذف شد.');
    }
}
