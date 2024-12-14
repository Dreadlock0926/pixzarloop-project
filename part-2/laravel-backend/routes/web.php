<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token(); 
});

// Genre routes
Route::get('genres', [GenreController::class, 'index']);
Route::post('genres', [GenreController::class, 'store']);
Route::get('genres/{id}', [GenreController::class, 'show']);
Route::put('genres/{id}', [GenreController::class, 'update']);
Route::delete('genres/{id}', [GenreController::class, 'destroy']);

// Role routes
Route::get('roles', [RoleController::class, 'index']);

// Book routes

Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::post('books', [BookController::class, 'store']);
Route::put('books/{id}', [BookController::class, 'update']);
Route::delete('books/{id}', [BookController::class, 'destroy']);