<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token(); 
});

// Auth routes
Route::post('login', [AuthController::class, 'login']);

// User routes
Route::post('users', [UserController::class, 'store']);

// Borrowing routes
Route::get('borrowings', [BorrowingController::class, 'index'])->middleware('auth:sanctum');
Route::post('borrowings', [BorrowingController::class, 'store'])->middleware('auth:sanctum');
Route::put('borrowings/{borrow_id}', [BorrowingController::class, 'update'])->middleware('auth:sanctum');
Route::put('borrowings/{borrow_id}/return', [BorrowingController::class, 'markReturned'])->middleware('auth:sanctum');

// Member routes
Route::resource('members', MemberController::class)->middleware('auth:sanctum');

// Author routes
Route::resource('authors', AuthorController::class)->middleware('auth:sanctum');

// Genre routes
Route::resource('genres', GenreController::class)->middleware('auth:sanctum');

// Role routes
Route::resource('roles', RoleController::class)->middleware('auth:sanctum');

// Book routes
Route::resource('books', BookController::class)->middleware('auth:sanctum');