<?php

use App\Models\User;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('register/', [RegistrationController::class, 'create'])->name("register");
Route::post('register/', [RegistrationController::class, 'store']);

Route::get('login/', [LoginController::class, 'create'])->name("login");
Route::post('login/', [LoginController::class, 'store']);
Route::get('logout/', [LoginController::class, 'destroy'])->name("logout");