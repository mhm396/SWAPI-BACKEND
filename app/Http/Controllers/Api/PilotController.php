<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Pilot;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('https://swapi.dev/api/people/');

        if ($response->successful()) {
            $pilotsData = $response->json()['results']; 

            $pilots = array_map(function($pilot) {
                return ['name' => $pilot['name']];
            }, $pilotsData);

            return response()->json($pilots);
        }

        return response()->json([
            'message' => 'No se pudieron obtener los pilotos.',
            'status' => 500
        ], 500);
    }

    //Prueba desde SWAPI para obtener a todos los pilotos
    public function allPilots() 
    {
        $response = Http::get('https://swapi.dev/api/people/');

        if ($response->successful()) {
            
            $pilotsData = $response->json()['results']; // Extraemos los datos de los pilotos desde la respuesta.
            
            $pilots = array_map(function($pilot) {
                return [
                    'name' => $pilot['name'],
                    'height' => $pilot['height'],
                    'mass' => $pilot['mass'],
                    'hair_color' => $pilot['hair_color'],
                    'skin_color' => $pilot['skin_color'],
                    'eye_color' => $pilot['eye_color'],
                    'birth_year' => $pilot['birth_year'],
                    'gender' => $pilot['gender'],
                    'homeworld' => $pilot['homeworld'],
                    'films' => $pilot['films'],
                    'species' => $pilot['species'],
                    'starships' => $pilot['starships'],
                    'vehicles' => $pilot['vehicles'],
                    'url' => $pilot['url'],
                ];
            }, $pilotsData);

            return response()->json($pilots);
        }

        return response()->json([
            'message' => 'No se pudieron obtener los pilotos.',
            'status' => 500
        ], 500);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
