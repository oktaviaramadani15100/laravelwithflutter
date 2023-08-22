<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register'])->name('register');
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('auth/me', [AuthController::class, 'me'])->name('me');
    Route::get('auth/logout', [AuthController::class, 'logout']);
});

Route::post('/payment', [PaymentController::class, 'create']);
