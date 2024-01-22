<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Admin\ProductsController;

Route::match(['POST', 'GET'], 'products/search/{search?}', [ProductsController::class, 'search'])
    ->name('products.search');

Route::apiResource('products', ProductsController::class);
