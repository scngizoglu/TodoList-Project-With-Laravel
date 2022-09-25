<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TodolistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("auth.login");
});
Route::get('/login',[\App\Http\Controllers\CustomAuthController::class,'login']);
Route::get('/registration',[\App\Http\Controllers\CustomAuthController::class,'registration']);
Route::post('/register-user',[\App\Http\Controllers\CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/login-user',[\App\Http\Controllers\CustomAuthController::class,'loginUser'])->name('login-user');
Route::get('/dashboard',[\App\Http\Controllers\CustomAuthController::class,'dashboard']);


Route::get('/todolist',[\App\Http\Controllers\TodolistController::class,'todolist'])->middleware('isLoggedIn');
Route::post('/todolist',[\App\Http\Controllers\TodolistController::class,'store'])->name('store');
Route::delete('/{todolist:id}',[\App\Http\Controllers\TodolistController::class,'destroy'])->name('destroy');
Route::get('/edit/{id}',[\App\Http\Controllers\CustomAuthController::class,'edit']);
Route::get('/logout',[\App\Http\Controllers\CustomAuthController::class,'logout']);

Route::post('/list-update',[\App\Http\Controllers\TodolistController::class,'listUpdate'])->name('list-update');
