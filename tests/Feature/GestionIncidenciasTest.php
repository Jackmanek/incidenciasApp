<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Incidencia;
use App\Livewire\GestionIncidencias;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GestionIncidenciasTest extends TestCase
{
    use RefreshDatabase;

    public function test_mount_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);

        Livewire::test(GestionIncidencias::class)
            ->assertSet('incidencias', Incidencia::where('asignado', $user->id)->get());

        $admin = User::factory()->create(['role' => 'administrador']);
        $this->actingAs($admin);

        Livewire::test(GestionIncidencias::class)
            ->assertSet('incidencias', Incidencia::all())
            ->assertSet('listaSoporte', User::where('role', 'soporte')->get());
    }

    public function test_render_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);
        Livewire::test(GestionIncidencias::class)
            ->assertViewIs('livewire.gestion-incidencias');
    }

    public function test_resetFields_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);
        Livewire::test(GestionIncidencias::class)
            ->call('resetFields')
            ->assertSet('title', '')
            ->assertSet('descripcion', '')
            ->assertSet('estado', 'To Do')
            ->assertSet('asignado', null)
            ->assertSet('incidenciaId', null);
    }

    public function test_createNewIncidencia_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);

        Livewire::test(GestionIncidencias::class)
            ->call('createNewIncidencia')
            ->assertSet('isCreating', true);
    }

    public function test_cambioEstado_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);

        $this->actingAs($user);

        $incidencia = Incidencia::factory()->create();

        Livewire::test(GestionIncidencias::class)
            ->call('cambioEstado', $incidencia->id)
            ->assertSet('incidenciaId', $incidencia->id)
            ->assertSet('estado', $incidencia->estado)
            ->assertSet('changeStatus', true);
    }

    public function test_asignarIncidencia_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);

        $this->actingAs($user);

        $incidencia = Incidencia::factory()->create();

        Livewire::test(GestionIncidencias::class)
            ->call('asignarIncidencia', $incidencia->id)
            ->assertSet('incidenciaId', $incidencia->id)
            ->assertSet('asignaSoporte', true);
    }

    public function test_store_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);

        Livewire::test(GestionIncidencias::class)
            ->set('title', 'Test Title')
            ->set('descripcion', 'Test Description')
            ->set('estado', 'To Do')
            ->call('store')
            ->assertHasNoErrors()
            ->assertSessionHas('message', 'Incidencia creada exitosamente.');
    }

    public function test_edit_method()
    {
        $user = User::factory()->create(['role' => 'administrador']);
        $this->actingAs($user);
        $incidencia = Incidencia::factory()->create();

        Livewire::test(GestionIncidencias::class)
            ->call('edit', $incidencia->id)
            ->assertSet('incidenciaId', $incidencia->id)
            ->assertSet('title', $incidencia->title)
            ->assertSet('descripcion', $incidencia->descripcion)
            ->assertSet('estado', $incidencia->estado)
            ->assertSet('asignado', $incidencia->asignado)
            ->assertSessionHas('message', "Editando incidencia ID: $incidencia->id");
    }

    public function test_update_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);

        $incidencia = Incidencia::factory()->create();

        $soporte = User::factory()->create(['role' => 'soporte']);

        Livewire::test(GestionIncidencias::class)
            ->set('incidenciaId', $incidencia->id)
            ->set('title', 'Updated Title')
            ->set('descripcion', 'Updated Description')
            ->set('estado', 'Doing')
            ->set('asignado', $soporte->id)
            ->call('update')
            ->assertHasNoErrors()
            ->assertSessionHas('message', 'Incidencia actualizada exitosamente.');
    }

    public function test_delete_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);

        $this->actingAs($user);

        $incidencia = Incidencia::factory()->create();

        Livewire::test(GestionIncidencias::class)
            ->call('delete', $incidencia->id)
            ->assertHasNoErrors()
            ->assertSessionHas('message', 'Incidencia eliminada exitosamente.');
    }

    public function test_actualizaEstado_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);
        $this->actingAs($user);
        $incidencia = Incidencia::factory()->create();

        Livewire::test(GestionIncidencias::class)
            ->set('incidenciaId', $incidencia->id)
            ->set('estado', 'Doing')
            ->call('actualizaEstado')
            ->assertSessionHas('message', 'Estado de la incidencia actualizado');
    }

    public function test_asignarSoporte_method()
    {
        $user = User::factory()->create(['role' => 'soporte']);

        $this->actingAs($user);
        $incidencia = Incidencia::factory()->create();
        $soporte = User::factory()->create(['role' => 'soporte']);

        Livewire::test(GestionIncidencias::class)
            ->set('incidenciaId', $incidencia->id)
            ->set('asignado', $soporte->id)
            ->call('asignarSoporte')
            ->assertHasNoErrors()
            ->assertSessionHas('message', 'Soporte asignado exitosamente.');
    }
}
