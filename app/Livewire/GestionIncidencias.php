<?php

namespace App\Livewire;

use App\Models\Incidencia;
use Livewire\Component;

class GestionIncidencias extends Component
{


    public $incidencias;
    public $title;
    public $descripcion;
    public $estado = 'To Do';
    public $asignado;
    public $incidenciaId;


    public function mount(){
        $this->incidencias = Incidencia::all();
    }

    public function render()
    {
        return view('livewire.gestion-incidencias');
    }

    public function resetFields(){
        $this->title = '';
        $this->descripcion = '';
        $this->estado = 'To Do';
        $this->asignado = null;
        $this->incidenciaId = null;
    }

    public function store(){
        $this->validate([
            'title' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'asignado' => 'nullable|exists:users,id',
        ]);

        Incidencia::create([
            'title' => $this->title,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'asignado' => $this->asignado,
            'creado' => auth()->id(),
        ]);

        session()->flash('message', 'Incidencia creada exitosamente.');

        $this->resetFields();
        $this->incidencias = Incidencia::all();
    }

    public function edit($id){
        $incidencia = Incidencia::findOrFail($id);

        $this->incidenciaId = $incidencia->id;
        $this->title = $incidencia->title;
        $this->descripcion = $incidencia->descripcion;
        $this->estado = $incidencia->estado;
        $this->asignado = $incidencia->asignado;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'asignado' => 'nullable|exists:users,id',
        ]);

        $incidencia = Incidencia::findOrFail($this->incidenciaId);

        $incidencia->update([
            'title' => $this->title,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'asignado' => $this->asignado,
        ]);

        session()->flash('message', 'Incidencia actualizada exitosamente.');

        $this->resetFields();
        $this->incidencias = Incidencia::all();
    }

    public function delete($id)
    {
        Incidencia::findOrFail($id)->delete();

        session()->flash('message', 'Incidencia eliminada exitosamente.');

        $this->incidencias = Incidencia::all();
    }



}
