<?php

use App\Http\Controllers\User\ModalController;
use App\Http\Controllers\User\ProductController;
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

Route::get('modal/{id}',[ModalController::class,'ApiModal']);
Route::get('/product/{id}',[ProductController::class,'ApiProduct']);
