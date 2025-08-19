<?php

namespace App\Http\Controllers;

use App\Models\User;
use \App\Models\Useractivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Storage;
class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $storages = Storage::select('id', 'name')->get();
        return view('auth.auth',compact('storages'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:15'],
            'mobile' => ['required', 'numeric ', 'regex:/^0\d{10}$/', 'unique:users'],
            'cardNumber' => ['required', 'string', 'min:3', 'max:6', 'unique:users'],
            'department' => ['required'],
            'role' => ['required'],
            'storage' => ['required'],
        ]);

        $data['mobile'] = Hash::make($data['mobile']);
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return redirect()->route('login.form');

    }


    public function showLoginForm()
    {
        $storages = Storage::select('id', 'name')->get();
        return view('auth.auth',compact('storages'));

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft Delete
        return redirect()->back()->with('success', 'کاربر با موفقیت حذف شد.');
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'کاربر با موفقیت بازیابی شد.');
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->back()->with('success', 'کاربر به طور کامل حذف شد.');
    }


    public function login(Request $request)
    {
        $data = $request->validate([
            'cardNumber' => ['required', 'string', 'min:3', 'max:6'],
            'mobile' => ['required', 'numeric ', 'regex:/^0\d{10}$/'],
        ]);

        $user = User::where('cardNumber', $data['cardNumber'])->first();

        if (!$user || !Hash::check($data['mobile'], $user->mobile)) {
            return response([
                'message' => "همکار گرامی ، شماره پرسنلی یا رمز عبور اشتباه می باشد"
            ], 401);
        }

            Auth::login($user);




        Useractivities::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in successfully',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->redirectBasedOnRole($user);
    }




    protected function redirectBasedOnRole(User $user)
    {

        $role = $user->role;

        if ($role === 'admin' || $role === 'author') {
            return redirect()->route('admin.dashboard');
        }

        // default viewer
        return redirect()->route('home');
    }


//    =======logout===============
    public function logout(Request $request)
    {
        // حذف توکن‌های احراز هویت (در صورت استفاده از Sanctum)
        $request->user()->tokens()->delete();

        // خروج از سیستم
        Auth::logout();

        // حذف session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // انتقال به صفحه ورود یا خانه
        return redirect()->route('login.form'); // یا route('home')
    }

}
