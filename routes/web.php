<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\ReportController;

Route::get('reports/{report_type}/export', [ReportController::class, 'export'])->name('reports.export');

Route::resource('reports', ReportController::class);
