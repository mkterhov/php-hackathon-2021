<?php

use App\Http\Controllers\BookingController;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//list, create, delete programmes
Route::get('programmes/{programme}', [ProgrammeController::class,'show']);
Route::delete('programmes/{programme}', [ProgrammeController::class,'destroy']);
Route::get('programmes', [ProgrammeController::class,'index']);
Route::post('programmes', [ProgrammeController::class,'store']);

//store booking
Route::post('bookings', [BookingController::class,'store']);
