<?php

use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\WebhookController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/file', [FileController::class, 'Upload']);
Route::post('/cobranca', [CobrancaController::class, 'getAll']);
Route::post('/hook/payment', [WebhookController::class, 'Payment']);

