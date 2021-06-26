<?php

use App\Http\Controllers\Clients\ClientsController;
use Illuminate\Support\Facades\Route;

Route::post('/client/store', [ClientsController::class, 'store']);
Route::get('/clients', [ClientsController::class, 'index']);
Route::get('/client/{id}', [ClientsController::class, 'show']);
Route::patch('/client/{id}', [ClientsController::class, 'update']);
Route::delete('/client/{id}', [ClientsController::class, 'destroy']);
