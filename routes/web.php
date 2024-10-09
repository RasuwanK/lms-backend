<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('welcome');
});

Route::get('/home',[App\Http\Controllers\UserController::class,'show'])
    ->name('home.show')
    ->middleware('auth');
Route::get('/login',[App\Http\Controllers\LoginController::class,'show'])
    ->name('login');
Route::post('/login',[App\Http\Controllers\LoginController::class,'login'])
    ->name('login.validate');
Route::post('/logout',[App\Http\Controllers\LoginController::class,'logout'])
    ->name('login.logout');
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');
Route::post('/home/update',[App\Http\Controllers\UserController::class,'update'])
    ->name('home.update')
    ->middleware('auth');
