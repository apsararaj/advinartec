<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'apiIndex']);
    Route::post('/tasks', [TaskController::class, 'apiStore']);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'apiUpdateStatus']);
    Route::get('/tasks/{task}/ai-summary', [TaskController::class, 'aiSummary']);
});
