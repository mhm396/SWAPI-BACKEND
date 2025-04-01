<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        $response = Http::get('https://swapi.dev/api/starships/9/');

        return response()->json();
    }
}
