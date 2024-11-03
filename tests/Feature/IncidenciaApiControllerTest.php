<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Incidencia;
use Laravel\Sanctum\Sanctum;

class IncidenciaApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_incidencias_admin()
    {
        $admin = User::factory()->create(['role' => 'administrador']);
        Sanctum::actingAs($admin);

        Incidencia::factory()->create(['estado' => 'Doing']);

        $response = $this->get('/api/incidencias?estado=Doing');

        $response->assertStatus(200)
            ->assertJsonStructure([['id', 'estado', 'asignado']]);
    }

    public function test_list_incidencias_soporte()
    {
        $soporte = User::factory()->create(['role' => 'soporte']);
        Sanctum::actingAs($soporte);

        Incidencia::factory()->create(['estado' => 'Doing', 'asignado' => $soporte->id]);

        $response = $this->get('/api/incidencias?estado=Doing');

        $response->assertStatus(200)
            ->assertJsonStructure([['id', 'estado', 'asignado']]);
    }

    public function test_list_incidencias_unauthorized()
    {

        $response = $this->get('/api/incidencias?estado=doing');

        $response->assertStatus(401)
            ->assertJson(['error' => 'Unauthorized']);
    }
}
