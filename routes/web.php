<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HistoryController;


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


Route::view('/signup', 'register');

Route::post('/login', [UsersController::class, 'login']);
Route::post('/users', [UsersController::class, 'create']);


Route::get('/', function (){
    return view('index');
});

Route::get('/contracts/getContracts', [ContractsController::class, 'getContracts']);
Route::get('/structure/getStructure', [StructureController::class, 'getStructures']);
Route::get('/equipment/getEquipment', [EquipmentController::class, 'getEquipments']);
Route::get('/provider/getProvider', [ProviderController::class, 'getProviders']);
Route::get('/employer/getEmployer', [EmployerController::class, 'getEmployer']);
Route::get('/user/getUser', [UsersController::class, 'getUser']);



Route::resource('equipment',EquipmentController::class);
Route::resource('contract',ContractsController::class);
Route::resource('provider',ProviderController::class);
Route::resource('structure',StructureController::class);
Route::resource('employe',EmployerController::class);
Route::resource('userCrud',UsersController::class);
Route::resource('History',HistoryController::class);




Route::view('/welcome', 'welcome');

Route::get('/{any}', function () {
    return view('app'); // Your main Blade file for Vue.js
})->where('any', '.*');












