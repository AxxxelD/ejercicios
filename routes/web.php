<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::resource('products', ProductController::class);
});
