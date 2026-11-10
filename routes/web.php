<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
use App\Http\Controllers\FeedController;

Route::get('/', [DogController::class, 'load']);
Route::get('/create', [DogController::class, 'load']);
Route::get('/feed/{id}', [FeedController::class, 'loadFeeding']);
Route::post('/dogs', [DogController::class, 'store']);
Route::post('/dogs/update', [DogController::class, 'edit']);
Route::post('/dogs/delete', [DogController::class, 'delete']);
return view('/create');
