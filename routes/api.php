<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NotificationController;


// Public Routes
Route::post('/login', [UsersController::class, 'login']);
Route::post('/signup', [UsersController::class, 'store']); // Changed to 'store' for standard RESTful practices
Route::get('/check-auth', [UsersController::class, 'checkAuth']);


// Protected API routes
Route::middleware('auth:sanctum')->group(function () {



    Route::get('/provider/getProvider', [ProviderController::class, 'getProviders']);

    Route::post('/logout', [UsersController::class, 'logout']);

    

    Route::get('/contracts/getContracts', [ContractsController::class, 'getContracts']);
    Route::get('/structure/getStructure', [StructureController::class, 'getStructures']);
    Route::get('/equipment/getEquipment', [EquipmentController::class, 'getEquipments']);
    Route::get('/employer/getEmployer', [EmployerController::class, 'getEmployer']);
    Route::get('/user/getUser', [UsersController::class, 'getUser']);
    Route::get('/history/getHistory', [HistoryController::class, 'getHistory']);
    Route::get('/notifications', [NotificationController::class, 'index']);


      
    Route::resource('equipment',EquipmentController::class);
    Route::resource('contract',ContractsController::class);
    Route::resource('provider',ProviderController::class);
    Route::resource('structure',StructureController::class);
    Route::resource('employe',EmployerController::class);
    Route::resource('userCrud',UsersController::class);
    Route::resource('History',HistoryController::class);

    // PDF generation
});
