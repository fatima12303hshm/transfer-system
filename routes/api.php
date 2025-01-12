<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'loginUser']);
Route::patch('user/generate-qr', [UserController::class, 'setQrCode']);
Route::get('user/get-user-data', [UserController::class, 'getUserData']); 
Route::get('user/transactions', [TransactionController::class, 'fetchUserTransactions']);
Route::post('user/transfer-balance', [TransactionController::class, 'submitTransaction']);
