<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Starship;
use App\Models\Pilot;
use App\Models\pilot_starship;

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
    protected $description = 'Importa los datos desde SWAPI para agregarlos en la base de datos local';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando la importación de Starships desde la API...');

        // Eliminar todos los registros sin truncar
        //Starship::query()->delete();
        //Pilot::query()->delete();
        //Resetear las tablas, funciona mejor truncarlas porque en mysql aun eliminando los registros no se reinician los ids
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pilot_starship')->truncate();
        Starship::truncate();
        Pilot::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->importStarships();
        $this->importPilots();
        $this->info('Datos importados correctamente');
    }

    function importStarships(){

        $urlStarships = 'https://swapi.dev/api/starships/';
       // $urlPilots = 'https://swapi.dev/api/people/';

        $response = Http::get($urlStarships);

        if ($response->successful()) {
            $starships = $response->json()['results'];
             
             //starship_pilot::truncate();

            foreach ($starships as $starship) {
                // Guardar datos de la nave espacial en la base de datos
                $starshipModel = Starship::create([
                    'name' => $starship['name'],
                    'model' => $starship['model'],
                    'starship_class' => $starship['starship_class'],
                    'cost_in_credits' => $starship['cost_in_credits'],
                    'manufacturer' => $starship['manufacturer'],
                ]);

                // Procesar los pilotos asociados a la nave
                foreach ($starship['pilots'] as $pilot) {
                    $pilotResponse = Http::get($pilot);

                    if ($pilotResponse->successful()) {
                        $pilotData = $pilotResponse->json();

                        // Crear o actualizar el piloto en la base de datos
                        $pilotModel = Pilot::updateOrCreate(
                            ['url' => $pilotData['url']], // Identificar por URL única
                            [
                                'name' => $pilotData['name'],
                            ]
                        );

                        // Verificar si el piloto ya está asignado a esta nave para evitar duplicados
                        // Cambiar la consulta para usar la columna correcta 'pilot_id'e
                            if (!DB::table('pilot_starship')
                            ->where('pilot_id', $pilotModel->pilot_id)
                            ->where('starship_id', $starshipModel->starship_id)
                            ->exists()) {
                            // Establecer la relación entre la nave y el piloto
                            DB::table('pilot_starship')->insert([
                                'pilot_id' => $pilotModel->pilot_id,
                                'pilot_name' => $pilotModel->name,
                                'starship_id' => $starshipModel->starship_id,
                                'starship_name' => $starshipModel->name,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    } else {
                        $this->error("Error al obtener los datos del piloto desde la URL: $pilot");
                    }
                }

            }

        } else {
            $this->error('Error al obtener los datos de la API');
        }
    }


    function importPilots() {
        $urlPilots = 'https://swapi.dev/api/people/';
        $response = Http::get($urlPilots);
    
        if ($response->successful()) {
            $pilots = $response->json()['results'];
    
            foreach ($pilots as $pilot) {
                // Comprobar si el piloto ya existe en la base de datos utilizando la URL
                $pilotModel = Pilot::where('url', $pilot['url'])->first();
    
                // Si no existe, creamos el nuevo piloto
                if (!$pilotModel) {
                    $pilotModel = Pilot::create([
                        'url' => $pilot['url'],
                        'name' => $pilot['name']
                    ]);
                } else {
                    // Si el piloto ya existe, lo actualizamos en caso de que haya cambiado el nombre
                    if ($pilotModel->name !== $pilot['name']) {
                        $pilotModel->update([
                            'name' => $pilot['name']
                        ]);
                    }
                }
            }
        } else {
            $this->error('Error al obtener los datos de los pilotos desde la API');
        }
    }
}
