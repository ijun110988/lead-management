<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\StaticTokenMiddleware;

Route::middleware([StaticTokenMiddleware::class])->group(function () {
    Route::post('/leads', [LeadController::class, 'store']);
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{lead}', [LeadController::class, 'show']);
    Route::put('/leads/{lead}', [LeadController::class, 'update']);
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);
});

Route::get('/test-data', function () {
    return response()->json(['message' => 'Access granted']);
})->middleware(StaticTokenMiddleware::class);

