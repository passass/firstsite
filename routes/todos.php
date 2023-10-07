<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Todos;
use App\Http\Controllers\TodosController;

/*Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard',[TasksController::class, 'index'])->name('dashboard');

    Route::get('/task',[TasksController::class, 'add']);
    Route::post('/task',[TasksController::class, 'create']);
    
    Route::get('/task/{task}', [TasksController::class, 'edit']);
    Route::post('/task/{task}', [TasksController::class, 'update']);
});*/

Route::get('api/todos/', ['middleware' => 'auth', 'uses' => 'App\Http\Controllers\TodosController@index'])->name("todos_all");
Route::post('api/todos/', ['middleware' => 'auth', 'uses' => 'App\Http\Controllers\TodosController@store'])->name("todos_create");
Route::delete('api/todos/{id}', ['middleware' => 'auth', 'uses' => 'App\Http\Controllers\TodosController@destroy'])->name("todos_destroy");
Route::put('api/todos/{id}', ['middleware' => 'auth', 'uses' => 'App\Http\Controllers\TodosController@update'])->name("todos_update");