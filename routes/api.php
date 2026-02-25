<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;


Route::post('/v1/auth/signup', [AuthController::class, 'signUp']);
Route::post('/v1/auth/signin', [AuthController::class, 'signIn']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/v1/auth/signout', [AuthController::class, 'signOut']);
    
    // Admin only routes
    Route::middleware('admin')->group(function (){
        Route::get('/v1/admin', [AdminController::class, 'index']);
        Route::post('/v1/users', [UserController::class, 'store']);
        Route::get('/v1/users', [UserController::class, 'index']);
        Route::put('/v1/users/{id}', [UserController::class, 'update']);
        Route::delete('/v1/users/{id}', [UserController::class, 'destroy']);
    });
    
    // Dev only routes
    Route::middleware('dev')->group(function (){
        Route::get('/v1/games', [GameController::class, 'index'] );
        Route::post('/v1/games', [GameController::class, 'store']);
        Route::get('/v1/games/{slug}', [GameController::class, 'show']);
        Route::delete('/v1/games/{slug}', [GameController::class, 'destroy']);
    });
    
});