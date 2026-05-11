<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/', function () {

    return Inertia::render('Home');

});

Route::get('/login', function () {

    return Inertia::render('Admin/Login');

})->name('login')
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/admin/products', function () {

        return Inertia::render('Admin/Products/Index');

    });

    Route::get('/admin/products/create', function () {

        return Inertia::render('Admin/Products/Form');

    });

    Route::get('/admin/products/{id}/edit', function ($id) {

        $product = Product::findOrFail($id);

        return Inertia::render('Admin/Products/Form', [
            'product' => $product,
        ]);

    });
});
