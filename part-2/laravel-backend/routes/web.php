<?php

use App\Http\Controllers\AuthorController;
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

// Author routes
Route::get('authors', [AuthorController::class, 'index']);
Route::post('authors', [AuthorController::class, 'store']);
Route::get('authors/{id}', [AuthorController::class, 'show']);
Route::put('authors/{id}', [AuthorController::class, 'update']);
Route::delete('authors/{id}', [AuthorController::class, 'destroy']);

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