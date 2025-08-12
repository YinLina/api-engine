<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// API product
Route::post('create/product', [ProductController::class, 'createProduct'])->name('create.product');

Route::get('get/product', [ProductController::class, 'getProduct'])->name('get.product');

Route::put('update/product/{id}', [ProductController::class, 'updateProduct'])->name('update.product');

Route::delete('delete/product/{id}', [ProductController::class,'deleteProduct'])->name('delete.product');

Route::get('product/search', [ProductController::class,'searchProduct'])->name('search.product');
