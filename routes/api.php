<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', \App\Http\Controllers\Auth\LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('import-diseases', \App\Http\Controllers\ImportDiseaseController::class);
    Route::get('summary-reports/{summaryReport}', \App\Http\Controllers\SummaryReportController::class);
});
