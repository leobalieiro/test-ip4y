<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [ClientController::class, 'view_create']);
Route::post('/client-create', [ClientController::class, 'create']);
Route::get('/get-clients', [ClientController::class, 'get_all']);
Route::get('/get-client/{id}', [ClientController::class, 'get']);
Route::post('/client-update', [ClientController::class, 'update']);
Route::get('/get-all-clients-data', [ClientController::class, 'get_all_data']);
Route::get('/client-delete/{id}', [ClientController::class, 'delete']);

// Route::get('/', function () {
//     return view('welcome');
// });
