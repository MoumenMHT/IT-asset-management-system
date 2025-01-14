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
Route::get('/generate-pdf/{affectationId}', [PdfController::class, 'generatePdf'])->name('generate.pdf');



Route::get('/', function (){
    return view('index');
});


Route::get('/{any}', function () {
    return view('app'); // Your main Blade file for Vue.js
})->where('any', '.*');












