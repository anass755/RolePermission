<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ProfileController,
    RoleController,
    ProductController,
    PermissionGroupController,
    PermissionController,
    UserController,
    CountryController
};


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('permissionGroup', PermissionGroupController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::get('/permissionShow/{role}',[RoleController::class, 'permissionShow'])->name('permissionShow');
    Route::post('/assign-permissions/{role}', [RoleController::class, 'storeAssign'])
     ->name('permission.assign.store');
     
    // Country resource routes
    Route::resource('countries', CountryController::class);

});

require __DIR__.'/auth.php';
