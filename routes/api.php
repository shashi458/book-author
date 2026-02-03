<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/authors',[AuthorController::class,'store']);
Route::get('/authors',[AuthorController::class,'index']);
Route::get('/authors/{id}',[AuthorController::class,'show']);
Route::put('/authors/{id}',[AuthorController::class,'update']);
Route::delete('/authors/{id}',[AuthorController::class,'destroy']);

Route::post('/books',[BookController::class,'store']);
Route::get('/books',[BookController::class,'index']);
Route::get('/books/{id}',[BookController::class,'show']);
Route::put('/books/{id}',[BookController::class,'update']);
Route::delete('/books/{id}',[BookController::class,'destroy']);
