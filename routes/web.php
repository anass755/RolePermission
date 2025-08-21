<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ProfileController,
    RoleController,
    ProductController,
    PermissionGroupController,
    PermissionController,
    UserController,
    LocationController
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
     
    // Location management routes with referential integrity
    Route::prefix('locations')->name('locations.')->group(function () {
        // Country routes
        Route::delete('/countries/{id}', [LocationController::class, 'deleteCountry'])->name('countries.delete');
        Route::delete('/countries/{id}/force', [LocationController::class, 'forceDeleteCountry'])->name('countries.force-delete');
        Route::get('/countries/{id}/relationships', [LocationController::class, 'getCountryRelationships'])->name('countries.relationships');
        Route::delete('/countries/bulk', [LocationController::class, 'bulkDeleteCountries'])->name('countries.bulk-delete');
        
        // State routes
        Route::delete('/states/{id}', [LocationController::class, 'deleteState'])->name('states.delete');
        Route::delete('/states/{id}/force', [LocationController::class, 'forceDeleteState'])->name('states.force-delete');
        Route::get('/states/{id}/relationships', [LocationController::class, 'getStateRelationships'])->name('states.relationships');
        
        // City routes
        Route::delete('/cities/{id}', [LocationController::class, 'deleteCity'])->name('cities.delete');
    });

});

require __DIR__.'/auth.php';
