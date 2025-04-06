<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Starship;
use App\Models\Pilot;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /*public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }*/

    public function test_get_starship_with_pilots()
    {
        // Crear una nave y dos pilotos
        $starship = Starship::factory()->create();
        $pilot1 = Pilot::factory()->create();
        $pilot2 = Pilot::factory()->create();

        // Establecer las relaciones en la tabla pivote pilots_starship
        $starship->pilots()->attach($pilot1->pilot_id, [
            'pilot_name' => $pilot1->name,
            'starship_name' => $starship->name,
        ]);
        $starship->pilots()->attach($pilot2->pilot_id, [
            'pilot_name' => $pilot2->name,
            'starship_name' => $starship->name,
        ]);

        // Realizar la solicitud para obtener los pilotos de la nave
        $response = $this->getJson("/api/swapi/starships/{$starship->starship_id}/pilots");

        // Verificar la respuesta
        $response->assertStatus(200)
                ->assertJson([
                    'starship_name' => $starship->name,
                    'pilots' => [
                        ['pilot_id' => $pilot1->pilot_id, 'name' => $pilot1->name],
                        ['pilot_id' => $pilot2->pilot_id, 'name' => $pilot2->name],
                    ],
                ]);
    }

    public function test_remove_pilot_from_starship()
    {
        // Crear una nave y un piloto
        $starship = Starship::factory()->create();
        $pilot = Pilot::factory()->create();

        $starship->pilots()->attach($pilot->pilot_id, [
            'pilot_name' => $pilot->name,
            'starship_name' => $starship->name,
        ]);

        // Realizar la solicitud para eliminar el piloto de la nave
        $response = $this->deleteJson("/api/swapi/starships/{$starship->starship_id}/remove-pilot/{$pilot->pilot_id}");

        // Verificar que la relación se haya eliminado correctamente
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Piloto eliminado de la nave correctamente',
                ]);

        $this->assertDatabaseMissing('pilot_starship', [
            'pilot_id' => $pilot->pilot_id,
            'starship_id' => $starship->starship_id,
        ]);
    }

    
}
