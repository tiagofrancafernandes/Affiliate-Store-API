<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Store\ProductsController;

Route::prefix('products')->name('products.')->group(function () {
    Route::match(['POST', 'GET'], '/search/{search?}', [ProductsController::class, 'search'])
        ->where('search', '.*')
        ->name('search');

    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::get('/{product}', [ProductsController::class, 'show'])->name('show');
});
