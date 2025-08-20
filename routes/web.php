<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\UserActivities;

// صفحه خوش‌آمدگویی
Route::get('/home',App\Livewire\User\Home::class)->name('home');

// فرم ثبت‌نام و ثبت‌نام
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

// فرم ورود و ورود
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');







// داشبورد ادمین

Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

        Route::get('/storages', App\Livewire\Admin\Storages::class)->name('admin.storages');
    Route::get('/storages/create', App\Livewire\Admin\CrudStorage\Create::class)->name('admin.storages.create');
    Route::get('/storages/edit', App\Livewire\Admin\CrudStorage\Edit::class)->name('admin.storages.edit');

        Route::get('/tools', App\Livewire\Admin\Tools::class)->name('admin.tools');
        Route::get('/tools/create', App\Livewire\Admin\CrudTools\Create::class)->name('admin.tools.create');
        Route::get('/tools/edit/{id}', App\Livewire\Admin\CrudTools\index::class)->name('admin.tools.edit');
        Route::get('/tools/show/{id}', App\Livewire\Admin\CrudTools\Show::class)->name('admin.tools.show');

        Route::get('/info', App\Livewire\Admin\ResultInfo::class)->name('admin.result-info');
    Route::get('/info/tools/{toolId}', App\Livewire\Admin\Infos\Tools::class)->name('admin.result.tools');

        Route::get('/pesonal', App\Livewire\Admin\Personal::class)->name('admin.personal');
//    Route::get('/user-activities/{user}', UserActivities::class)->name('user.activities.index');

    Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/users/{id}/restore', [AuthController::class, 'restore'])->name('admin.users.restore');
    Route::delete('/users/{id}/force', [AuthController::class, 'forceDelete'])->name('admin.users.forceDelete');

        Route::get('/transfer/index', App\Livewire\Admin\Transfer\Index::class)->name('admin.transfer.index');
        Route::get('/transfer/form', App\Livewire\Admin\Transfer\TransferForm::class)->name('admin.transfer.form');



});
//===logout==================================

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


