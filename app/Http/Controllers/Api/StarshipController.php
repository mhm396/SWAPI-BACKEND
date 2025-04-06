<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $starships = Starship::select('starship_id','name', 'model')->get();

        return response()->json($starships);
    }

    public function allStarship()
    {
        $starships = Starship::all();

        return response()->json($starships);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'starship_class' => 'required|string|max:255',
            'cost_in_credits' => 'required|string',
            'manufacturer' => 'required|string|max:255',
        ]);

    
        // Crear un nuevo registro en la base de datos
        $starship = Starship::create([
            'name' => $validatedData['name'],
            'model' => $validatedData['model'],
            'starship_class' => $validatedData['starship_class'],
            'cost_in_credits' => $validatedData['cost_in_credits'],
            'manufacturer' => $validatedData['manufacturer'],
        ]);

        // Verificar si la creación fue exitosa
        if ($starship) {
            return response()->json([
                'message' => 'Nave creada correctamente',
                'data' => $starship,
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error al crear la nave',
                'status' => 500
            ], 500);
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $starship = Starship::find($id);

        if (!$starship) {
            return response()->json([
                'message' => 'Nave no encontrada',
                'status' => 404
            ], 404);
        }

        return response()->json($starship);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',           
            'model' => 'nullable|string|max:255',          
            'starship_class' => 'nullable|string|max:255', 
            'cost_in_credits' => 'nullable|string',       
            'manufacturer' => 'nullable|string|max:255',  
        ]);

        $starship = Starship::find($id);

        if (!$starship) {
            return response()->json([
                'message' => 'Nave no encontrada',
                'status' => 404
            ], 404);
        }

        // Llenar los campos y actualizar el registro
        $starship->fill($validatedData);
        // Guardar los cambios
        $starship->save();

        return response()->json([
            'message' => 'Nave actualizada correctamente',
            'data' => $starship,
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)//$name
    {
        // Buscar la starship por nombre
        //$starship = Starship::where('name', $name)->first();
       
        $starship = Starship::find($id);

        if (!$starship) {
            return response()->json([
                'message' => 'Nave no encontrada',
                'status' => 404
            ], 404);
        }

        // Eliminar la nave
        $starship->delete();

        return response()->json([
            'message' => 'Nave eliminada correctamente',
            'status' => 200
        ]);
    }

    public function getStarshipWithPilots($id)
    {
        // Buscar la nave por su ID
        $starship = Starship::with('pilots')->find($id);

        if (!$starship) {
            return response()->json([
                'message' => 'Nave no encontrada',
                'status' => 404
            ], 404);
        }

        // Formatear la respuesta con el nombre de la nave y los nombres de los pilotos
        $response = [
            'starship_name' => $starship->name,
            'manufacturer' => $starship->manufacturer,
            'cost_in_credits' => $starship->cost_in_credits,
            'pilots' => $starship->pilots->map(function ($pilot) {
                return [
                    'pilot_id' => $pilot->pilot_id,  // Agregar el ID del piloto
                    'name' => $pilot->name
                ];
            })
        ];

        return response()->json($response);
    }

    public function addPilot($starshipId, $pilotId)
{
    $starship = Starship::find($starshipId);
    if (!$starship) {
        return response()->json([
            'message' => 'Nave no encontrada',
            'status' => 404
        ], 404);
    }

    $pilot = Pilot::find($pilotId);
    if (!$pilot) {
        return response()->json([
            'message' => 'Piloto no encontrado',
            'status' => 404
        ], 404);
    }

    // Verificar si la relación ya existe
    if (!$starship->pilots()->where('pilot_starship.pilot_id', $pilotId)->exists()) {
        // Establecer la relación entre la nave y el piloto con datos
        $starship->pilots()->attach($pilotId, [
            'pilot_name' => $pilot->name,
            'starship_name' => $starship->name,
        ]);

        return response()->json([
            'message' => 'Piloto agregado a la nave correctamente',
            'pilot_name' => $pilot->name,
            'status' => 200
        ]);
    }

    return response()->json([
        'message' => 'El piloto ya está asignado a esta nave',
        'status' => 400
    ], 400);
}
    
    public function removePilot($starshipId, $pilotId)
    {
        $starship = Starship::find($starshipId);
        if (!$starship) {
            return response()->json([
                'message' => 'Nave no encontrada',
                'status' => 404
            ], 404);
        }

        $pilot = Pilot::find($pilotId);
        if (!$pilot) {
            return response()->json([
                'message' => 'Piloto no encontrado',
                'status' => 404
            ], 404);
        }

        // Verificar si la relación existe
        if ($starship->pilots()->where('pilot_starship.pilot_id', $pilotId)->exists()) {
            // Eliminar la relación entre la nave y el piloto
            $starship->pilots()->detach($pilotId);

            return response()->json([
                'message' => 'Piloto eliminado de la nave correctamente',
                'status' => 200
            ]);
        }

        return response()->json([
            'message' => 'El piloto no está asignado a esta nave',
            'status' => 400
        ], 400);
    }
}
