<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ToolsExportController;

// صفحه خوش‌آمدگویی کاربر
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.page');

Route::get('/home', App\Livewire\User\Home::class)->name('home');

// =================== فرم ثبت‌نام ===================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// =================== فرم ورود ===================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// =================== خروج ===================
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// =================== داشبورد و پنل ادمین ===================
Route::middleware(['auth', 'role:admin,author'])->prefix('admin')->group(function () {

    // داشبورد اصلی
    Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // مدیریت انبارها
    Route::get('/storages', App\Livewire\Admin\Storages::class)->name('admin.storages');
    Route::get('/storages/create', App\Livewire\Admin\CrudStorage\Create::class)->name('admin.storages.create');
    Route::get('/storages/edit', App\Livewire\Admin\CrudStorage\Edit::class)->name('admin.storages.edit');
    Route::get('/storages/show/{id}', App\Livewire\Admin\CrudStorage\Show::class)->name('admin.storages.show');

    // مدیریت ابزارها
    Route::get('/tools', App\Livewire\Admin\Tools::class)->name('admin.tools');
    Route::get('/tools/create', App\Livewire\Admin\CrudTools\Create::class)->name('admin.tools.create');
    Route::get('/tools/edit/{id}', App\Livewire\Admin\CrudTools\Index::class)->name('admin.tools.edit');
    Route::get('/tools/show/{id}', App\Livewire\Admin\CrudTools\Show::class)->name('admin.tools.show');

    // اطلاعات و گزارش‌ها
    Route::get('/info', App\Livewire\Admin\ResultInfo::class)->name('admin.result-info');
    Route::get('/info/tools/{toolId}', App\Livewire\Admin\Infos\Tools::class)->name('admin.result.tools');
    Route::get('/activities', \App\Livewire\Admin\UserActivities::class)->name('admin.activities');
    // پرسنل و کاربران
    Route::get('/personal', App\Livewire\Admin\Personal::class)->name('admin.personal');
    // عملیات روی کاربران
    Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/users/{id}/restore', [AuthController::class, 'restore'])->name('admin.users.restore');
    Route::delete('/users/{id}/force', [AuthController::class, 'forceDelete'])->name('admin.users.forceDelete');

    // مدیریت انتقالات
    Route::get('/transfer/index', App\Livewire\Admin\Transfer\Index::class)->name('admin.transfer.index');
    Route::get('/transfer/form', App\Livewire\Admin\Transfer\TransferForm::class)->name('admin.transfer.form');
    Route::get('/transfer/show/{id}', App\Livewire\Admin\Transfer\Show::class)->name('admin.transfer.show');
    Route::get('/transfer/{transfer}/return', App\Livewire\Admin\Transfer\TransferReturnForm::class)->name('transfer.return');

    //حروجی pdf excel
//    Route::get('/export', App\Livewire\Component\Export::class)->name('admin.export');
    Route::get('/admin/tools/export', [ToolsExportController::class, 'export'])
        ->name('admin.tools.export');
});
