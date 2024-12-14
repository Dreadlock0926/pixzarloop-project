<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorController;
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
Route::resource('authors', AuthorController::class);

// Genre routes
Route::resource('genres', GenreController::class);

// Role routes
Route::resource('roles', RoleController::class);

// Book routes
Route::resource('books', BookController::class);