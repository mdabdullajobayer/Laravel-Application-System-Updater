<?php

use Illuminate\Support\Facades\Route;
use Jobayer\LaravelAppUpdater\Http\Controllers\UpdaterController;

Route::get('/system-updater', [UpdaterController::class, 'index']);
Route::post('/system-updater', [UpdaterController::class, 'processUpdate']);
