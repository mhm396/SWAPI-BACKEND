<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StarshipController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


Route::get('/swapi', [StarshipController::class, "index"]); //En principio solo mostrare el nombre de la nave y sus pilotos (actualmente nombre y modelo)

Route::get('/swapi/all', [StarshipController::class, "allStarship"]); //Mostrar todas las naves

Route::post('/swapi', [StarshipController::class, "store"]); //Agregar una nave

Route::patch('/swapi/{id}', [StarshipController::class, "update"]); //Actualizar una nave

Route::delete('/swapi/{id}', [StarshipController::class, "destroy"]); //Eliminar una nave