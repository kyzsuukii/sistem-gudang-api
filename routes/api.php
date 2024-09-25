<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Crud\CategoryController;
use App\Http\Controllers\Api\Crud\ItemController;
use App\Http\Controllers\Api\Crud\MutationController;
use Illuminate\Support\Facades\Route;

Route::any('ping', fn() => response()->json(['message' => 'pong']));

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });
});

Route::middleware('auth:sanctum')->prefix('crud')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/{category}/items', [CategoryController::class, 'searchItems']);

    Route::apiResources([
        'items' => ItemController::class,
        'mutations' => MutationController::class,
    ]);
});
