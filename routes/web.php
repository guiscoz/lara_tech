<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
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
    Route::get('', [EventController::class, 'index'])->name('event.index');
    Route::get('/show/{id}', [EventController::class, 'show'])->name('event.show');
});

Route::group(['prefix' => 'event'], function () {
    Route::get('', [CampusController::class, 'index'])->name('campus.index');
    Route::get('/show/{id}', [CampusController::class, 'show'])->name('campus.show');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('', [CourseController::class, 'index'])->name('course.index');
    Route::get('/show/{id}', [CourseController::class, 'show'])->name('course.show');
});

Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix' => 'role'], function () {
        Route::get('', [RoleController::class, 'index'])->name('role.index');
        Route::get('/{role}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('/{role}/permissions/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('/{id}/roles', [UserController::class, 'roles'])->name('user.roles');
        Route::put('/{id}/roles/sync', [UserController::class, 'rolesSync'])->name('user.rolesSync');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::group(['prefix' => 'campus'], function () {
        Route::get('/create', [CampusController::class, 'create'])->name('campus.create');
        Route::post('/store', [CampusController::class, 'store'])->name('campus.store');
        Route::get('/edit/{id}', [CampusController::class, 'edit'])->name('campus.edit');
        Route::put('/update/{id}', [CampusController::class, 'update'])->name('campus.update');
        Route::delete('/delete/{id}', [CampusController::class, 'destroy'])->name('campus.destroy');
    });

    Route::group(['prefix' => 'event'], function () {
        Route::get('/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/store', [EventController::class, 'store'])->name('event.store');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/delete/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/create', [CourseController::class, 'create'])->name('course.create');
        Route::post('/store', [CourseController::class, 'store'])->name('course.store');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
        Route::put('/update/{id}', [CourseController::class, 'update'])->name('course.update');
        Route::delete('/delete/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
        Route::post('/enroll/{id}', [CourseController::class, 'enroll'])->name('course.enroll');
    });
});
