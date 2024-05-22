<?php

use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/express/create', [StripeController::class, 'createAccount']);
Route::post('/express/create/{id}/link', [StripeController::class, 'createAccountLink']);
Route::get('/express/retrieve/{id}', [StripeController::class, 'retrieveAccount']);
Route::get('/express/login/{id}/link', [StripeController::class, 'loginAccountLink']);
Route::post('/express/payout/{id}', [StripeController::class, 'payoutAccount']);
Route::post('/express/redirect', function () {
    return response()->json(["data" => "success"]);
});