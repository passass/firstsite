<?php

use Illuminate\Support\Facades\Route;
use App\Models\Todos;
use App\Http\Controllers\TodosController;

Route::get('/', function () {
    return view('main');
})->name('index');

Route::get('about/', function () {
    return view('about');
})->name('about');

Route::get('todos/', [TodosController::class, 'show'])->name("todos");

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    // Passport routes...
});

