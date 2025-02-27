<?php

use App\Http\Controllers\API\LeadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.token', 'throttle:60,1'])->group(function () {
    Route::post('/leads', [LeadController::class, 'store']);
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{id}', [LeadController::class, 'show']);
    Route::put('/leads/{id}', [LeadController::class, 'update']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
});

// Route::get('/leads', [LeadController::class, 'index'])->middleware('api.token');
