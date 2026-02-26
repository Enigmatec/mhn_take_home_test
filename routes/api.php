<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('import-diseases', \App\Http\Controllers\ImportDiseaseController::class);
Route::get('summary-reports/{summaryReport}', \App\Http\Controllers\SummaryReportController::class);
