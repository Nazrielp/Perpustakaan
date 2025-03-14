<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReturningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('/books', BooksController::class)->middleware('auth:sanctum');
Route::apiResource('/borrow', BorrowingController::class)->middleware('auth:sanctum');
Route::apiResource('/return', ReturningController::class)->middleware('auth:sanctum');
