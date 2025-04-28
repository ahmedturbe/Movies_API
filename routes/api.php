<?php

use App\Http\Controllers\API\ActorController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// User registration and login routes
// These routes are used for user registration and login
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Protected routes that require authentication
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('api')->group(function () {
    Route::get('/actors', [ActorController::class, 'index']);
    Route::post('/actors', [ActorController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/actors/{slug}', [ActorController::class, 'show']);
    Route::put('/actors/{slug}', [ActorController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/actors/{slug}', [ActorController::class, 'destroy'])->middleware('auth:sanctum');
});
