<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ScheduledTransferController;
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

Route::post('/schedule-transfer', [TransferController::class, 'scheduleTransfer']);

Route::post('/scheduled-transfers', [TransferController::class, 'store']);
Route::get('/process-scheduled-transfers', [TransferController::class, 'processScheduledTransfers']);