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
             $pilots = Pilot::all();
    
            return response()->json($pilots);
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
        $pilot = Pilot::find($id);

        if (!$pilot) {
            return response()->json([
                'message' => 'Piloto no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($pilot);
    }

    public function getPilotWithStarships($id)
    {
        // Buscar el piloto por su ID
        $pilot = Pilot::with('starships')->find($id);

        if (!$pilot) {
            return response()->json([
                'message' => 'Piloto no encontrado',
                'status' => 404
            ], 404);
        }

        // Formatear la respuesta con el nombre del piloto y los nombres de las naves
        $response = [
            'pilot_name' => $pilot->name,
            'starships' => $pilot->starships->map(function ($starship) {
                return $starship->name;
            })
        ];

        return response()->json($response);
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
