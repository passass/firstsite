<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Todos;
use App\Http\Controllers\TodosController;

/*Route::get('/user', function (Request $request) {
    $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln(" getting user ");
    return $request->user();
})->middleware('auth:api');
*/

Route::get('/user', function (Request $request) {
    return $request->user(); 
})->middleware('auth:api');