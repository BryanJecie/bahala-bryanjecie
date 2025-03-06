<?php

use App\Domains\Dashboard\Http\Controllers\APIStoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'working-hours'], function () {
    Route::get('/', [APIStoreController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/status', [APIStoreController::class, 'status']);
    Route::post('/status', [APIStoreController::class, 'update']);

    Route::delete('/status', [APIStoreController::class, 'destroy']);
});
