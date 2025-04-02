<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\StarshipController;
use App\Http\Controllers\Api\PilotController;


Route::get('/swapi', [StarshipController::class, "index"]); //En principio solo mostrare el nombre de la nave y sus pilotos (actualmente nombre y modelo)

Route::get('/swapi/all', [StarshipController::class, "allStarship"]); //Mostrar todas las naves

Route::post('/swapi', [StarshipController::class, "store"]); //Agregar una nave

Route::patch('/swapi/{id}', [StarshipController::class, "update"]); //Actualizar una nave

Route::delete('/swapi/{id}', [StarshipController::class, "destroy"]); //Eliminar una nave

Route::get('/swapi/pilots', [PilotController::class, "index"]);//Mostrar pilotos

Route::get('/swapi/allpilots', [PilotController::class, "allPilots"]);//Mostrar pilotos

Route::post('/swapi/starships/{starship_id}/add-pilot/{pilot_id}', [StarshipController::class, "addPilot"]); //Agregar un piloto a una nave

Route::delete('/swapi/starships/{starship_id}/remove-pilot/{pilot_id}', [StarshipController::class, "removePilot"]); //Eliminar un piloto de una nave
