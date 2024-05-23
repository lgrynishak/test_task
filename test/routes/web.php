<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::put('/data', [DataController::class, 'refresh']);
Route::get('/jobs', [DataController::class, 'listJobs']);
Route::get('/data', [DataController::class, 'search']);
Route::delete('/data', [DataController::class, 'purge']);

