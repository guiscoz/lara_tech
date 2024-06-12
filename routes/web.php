<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'campus'], function () {
    Route::get('', [CampusController::class, 'index'])->name('campuses');
    Route::get('/show/{id}', [CampusController::class, 'show'])->name('campus.show');
});

Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix' => 'role'], function () {
        Route::get('', [RoleController::class, 'index'])->name('roles');
        Route::get('/{role}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('/{role}/permissions/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('', [PermissionController::class, 'index'])->name('permissions');
        Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'index'])->name('users');
        Route::get('/{id}/roles', [UserController::class, 'roles'])->name('user.roles');
        Route::put('/{id}/roles/sync', [UserController::class, 'rolesSync'])->name('user.rolesSync');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroyUser');
    });

    Route::group(['prefix' => 'campus'], function () {
        Route::get('/create', [CampusController::class, 'create'])->name('campus.create');
        Route::post('/store', [CampusController::class, 'store'])->name('campus.store');
        Route::get('/edit/{id}', [CampusController::class, 'edit'])->name('campus.edit');
        Route::put('/update/{id}', [CampusController::class, 'update'])->name('campus.update');
        Route::delete('/delete/{id}', [CampusController::class, 'destroy'])->name('campus.destroy');
    });
});
