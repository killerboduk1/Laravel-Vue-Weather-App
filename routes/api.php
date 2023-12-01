<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('get/city', [ApiController::class, 'Index']);
Route::post('get/current/city', [ApiController::class, 'CurrentCity']);
Route::post('get/related/places', [ApiController::class, 'RelatedPlaces']);
Route::get('get/city/{city}', [ApiController::class, 'AutoCompleteCity']);
