<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SoftwareLicenseController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CredentialController;

Route::get('/', function () {
    return view('welcome');
});

// Asset Management Resource Routes
Route::resource('assets', AssetController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('software-licenses', SoftwareLicenseController::class);
Route::resource('vendors', VendorController::class);
Route::resource('credentials', CredentialController::class);
