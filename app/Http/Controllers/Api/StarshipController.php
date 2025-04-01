<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Models\Starship;

class StarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $starships = Starship::select('name', 'model')->get();

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
            'message' => 'Nave catualizada correctamente',
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
}
