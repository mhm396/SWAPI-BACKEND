<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StarshipController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


Route::get('/swapi', [StarshipController::class, "index"]);
// Route::get('/swapi', function(){
//     return "Hola funciona";
// });


Route::get('/swapi/{id}', [StarshipController::class, "show"]);