<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Agency Request Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // Get all agency requests for admin index
    Route::get('/agency-requests', [AgencyController::class, 'getAgencyRequests'])
        ->name('admin.agency-requests.index');
    
    // View specific agency request details (for modal)
    Route::get('/agency-requests/{id}', [AgencyController::class, 'viewAgencyRequest'])
        ->name('admin.agency-requests.view');
    
    // Approve or reject agency request
    Route::post('/agency-requests/approve', [AgencyController::class, 'approveAgencyRequest'])
        ->name('admin.agency-requests.approve');
});

// API Routes (if you prefer to use API routes instead)
Route::prefix('api/admin')->middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/agency-requests', [AgencyController::class, 'getAgencyRequests']);
    Route::get('/agency-requests/{id}', [AgencyController::class, 'viewAgencyRequest']);
    Route::post('/agency-requests/approve', [AgencyController::class, 'approveAgencyRequest']);
});