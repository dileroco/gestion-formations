<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FormationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/formations', [FormationController::class, 'index']);
Route::get('/formations/{formation}', [FormationController::class, 'show']);
Route::post('/contact', [ContactController::class, 'store']);
