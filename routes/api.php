<?php

use App\Http\Controllers\Auth\LogOut;
use App\Http\Controllers\Auth\Token;
use App\Http\Controllers\ProductController;
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
Route::post('/auth/token', Token::class);
Route::post('/auth/logout', LogOut::class)
    ->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('product')->group(function() {
    Route::resource('', ProductController::class)
        ->parameter('', 'product');;
});

