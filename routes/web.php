<?php

use App\Http\Controllers\AutentikasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HalamanController;

Route::get('/dashboard', HalamanController::class, "basic")->name('dashboard');

Route::get('{path}', HalamanController::class)->where('path', '(.*)')->name("notFound");

Auth::routes();
Route::post('/login', [AutentikasiController::class, 'loginDefault']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
