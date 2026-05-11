<?php

use App\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['prefix' => 'products'], function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/trashed', [ProductController::class, 'getTrashed']);
        Route::get('/restore/{product}', [ProductController::class, 'restore']);
        Route::patch('/{product}', [ProductController::class, 'update']);
        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });
});

Route::apiResource('/products', ProductController::class)->only(['index', 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
