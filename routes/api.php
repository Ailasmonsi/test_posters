<?php

use App\Http\Controllers\PosterController;
use Illuminate\Support\Facades\Route;

Route::get('posters', [PosterController::class, 'index']);
Route::get('posters/{id}', [PosterController::class, 'show']);
Route::post('posters', [PosterController::class, 'store']);
