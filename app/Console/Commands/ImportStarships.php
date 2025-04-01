<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Starship;

class ImportStarships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-starships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa los datos de las desde SWAPI para agregarlos en la base de datos local';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando la importación de Starships desde la API...');

        $url = 'https://swapi.dev/api/starships/';

        $response = Http::get($url);

        if ($response->successful()) {
            $starships = $response->json()['results'];

             // Reseteamos la base de datos, eliminando todos los registros existentes en la tabla 'starships'
             Starship::truncate(); // Esto eliminará todos los registros de la tabla

            foreach ($starships as $starship) {
                // Guardar datos de la nave espacial en la base de datos
                Starship::create([
                    'name' => $starship['name'],
                    'model' => $starship['model'],
                    'starship_class' => $starship['starship_class'],
                    'cost_in_credits' => $starship['cost_in_credits'],
                    'manufacturer' => $starship['manufacturer'],
                ]);
            }

            $this->info('Naves importadas correctamente');
        } else {
            $this->error('Error al obtener los datos de la API');
        }
    }
}
