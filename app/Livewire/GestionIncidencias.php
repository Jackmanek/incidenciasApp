<?php

namespace App\Livewire;

use App\Models\Incidencia;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        if($user->role === 'soporte'){
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        }else{
            $this->incidencias = Incidencia::all();
        }

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
        $user = Auth::user();
        $this->validate([
            'title' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'asignado' => 'nullable|exists:users,id',
        ]);

        if($user->role === 'soporte'){
            Incidencia::create([
            'title' => $this->title,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'asignado' => auth()->id(),
            'creado' => auth()->id(),
        ]);
        }else{
            Incidencia::create([
                'title' => $this->title,
                'descripcion' => $this->descripcion,
                'estado' => $this->estado,
                'asignado' => $this->asignado,
                'creado' => auth()->id(),
            ]);
        }


        session()->flash('message', 'Incidencia creada exitosamente.');


        $this->incidencias = Incidencia::all();
        $this->resetFields();
    }

    public function edit($id){
        $incidencia = Incidencia::findOrFail($id);
        $this->incidenciaId = $incidencia->id;
        $this->title = $incidencia->title;
        $this->descripcion = $incidencia->descripcion;
        $this->estado = $incidencia->estado;
        $this->asignado = $incidencia->asignado;
        session()->flash('message', "Editando incidencia ID: $id");

    }

    public function update(){
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

    public function delete($id){
        Incidencia::findOrFail($id)->delete();

        session()->flash('message', 'Incidencia eliminada exitosamente.');

        $this->incidencias = Incidencia::all();
    }
    public function updateStatus($id, $estado){
        $user = Auth::user();
        $incidencia = Incidencia::findOrFail($id);

        if ($user->role === 'soporte' && $incidencia->asignado !== $user->id) {
            abort(403, 'No tienes permiso para actualizar esta incidencia');
        }

        $incidencia->update([
            'estado' => $estado,
        ]);

        session()->flash('message', 'Estado de la incidencia actualizado');
        $this->mount();
    }
}
