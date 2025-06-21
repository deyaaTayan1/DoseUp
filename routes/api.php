<?php

use App\Http\Controllers\Admin\AdminPharmacistController;
use App\Http\Controllers\Admin\AdminAuthController;


use App\Http\Controllers\PharmacistAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//  -------------------------------------------------------------
//                      Admin Routes
// ------------------------------------------------------------- 
Route::prefix('admin')->group(function () {
    Route::get('isAdminExists', [AdminAuthController::class, 'isAdminExists']);
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        // pharmacists management
        Route::get('getAllPharmacists', [AdminPharmacistController::class, 'getAllPharmacists']);
        Route::post('createPharmacist', [AdminPharmacistController::class, 'createPharmacist']);
        Route::get('showPharmacist/{id}', [AdminPharmacistController::class, 'showPharmacist']);
        Route::post('editPharmacist/{id}', [AdminPharmacistController::class, 'editPharmacist']);
        Route::delete('deletePharmacist/{id}', [AdminPharmacistController::class, 'deletePharmacist']);
    });
});

//  -------------------------------------------------------------
//                      pharmacist Routes
// -------------------------------------------------------------

Route::prefix('pharmacist')->group(function () {
    Route::post('login', [PharmacistAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [PharmacistAuthController::class, 'logout']);
    });
});

