<?php

use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Languages\LanguageController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', function () {
    return view('contents.main.index');
});

Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware(['language', 'auth', 'verified'])->group(function () {
    Route::group(['prefix' => 'dashboards', 'as' => 'dashboards.'], function () {
        Route::get('', function () {
            return redirect()->route('dashboards.welcome');
        })->name('index');

        Route::get('welcome', [DashboardController::class, 'index'])->name('welcome');
        Route::get('main', [DashboardController::class, 'main'])->name('main')->middleware('permission:dashboard.main');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('', [RoleController::class, 'index'])->name('index')->middleware('permission:role.list');
        Route::post('', [RoleController::class, 'store'])->name('store')->middleware('permission:role.create');
        Route::get('create', [RoleController::class, 'create'])->name('create')->middleware('permission:role.create');
        Route::get('{id}', [RoleController::class, 'show'])->name('show')->middleware('permission:role.show');
        Route::put('{id}', [RoleController::class, 'update'])->name('update')->middleware('permission:role.edit');
        Route::delete('{id}', [RoleController::class, 'destroy'])->name('destroy')->middleware('permission:role.destroy');
        Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('permission:role.edit');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', [UserController::class, 'index'])->name('index')->middleware('permission:user.list');
        Route::post('', [UserController::class, 'store'])->name('store')->middleware('permission:user.create');
        Route::get('create', [UserController::class, 'create'])->name('create')->middleware('permission:user.create');
        Route::get('{id}', [UserController::class, 'show'])->name('show')->middleware('permission:user.show');
        Route::put('{id}', [UserController::class, 'update'])->name('update')->middleware('permission:user.edit');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy')->middleware('permission:user.destroy');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware('permission:user.edit');
        Route::get('{id}/edit/security', [UserController::class, 'editSecurity'])->name('edit.security')->middleware('permission:user.edit-security');
        Route::put('{id}/email', [UserController::class, 'updateEmail'])->name('update.email')->middleware('permission:user.edit-security');
        Route::put('{id}/password', [UserController::class, 'updatePassword'])->name('update.password')->middleware('permission:user.edit-security');
        Route::get('{id}/edit/role', [UserController::class, 'editRole'])->name('edit.role')->middleware('permission:user.edit-role');
        Route::put('{id}/role', [UserController::class, 'updateRole'])->name('update.role')->middleware('permission:user.edit-role');
    });
});

require __DIR__ . '/auth.php';
