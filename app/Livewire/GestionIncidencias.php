<?php

namespace App\Livewire;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GestionIncidencias extends Component
{
    public $incidencias;
    public $title;
    public $descripcion;
    public $estado = 'To Do';
    public $asignado = "";
    public $incidenciaId;
    public $isCreating = false;
    public $changeStatus = false;
    public $asignarInci = false;
    public $asignaSoporte = false;
    public $isModalOpen = true;
    public $listaSoporte;


    public function mount(){
        $user = Auth::user();
        if($user->role === 'soporte'){
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        }elseif($user->role === 'administrador'){
            $this->incidencias = Incidencia::all();
            $this->listaSoporte = User::where('role', 'soporte')->get();
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

    public function createNewIncidencia(){
        $this->resetFields();
        $this->isCreating = true;
    }

    public function cambioEstado($id){
        $this->incidenciaId = $id;
        $incidencia = Incidencia::findOrFail($id);
        $this->estado = $incidencia->estado;
        $this->changeStatus = true;
    }

    public function asignarIncidencia($id){
        $this->incidenciaId = $id;
        $this->asignaSoporte = true;
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
            $user->creador()->create([
            'title' => $this->title,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'asignado' => $user->id,
        ]);
        }else{
            $user->creador()->create([
                'title' => $this->title,
                'descripcion' => $this->descripcion,
                'estado' => $this->estado,
                'asignado' => $this->asignado,
            ]);
        }

        $user = Auth::user();
        if($user->role === 'soporte'){
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        }elseif($user->role === 'administrador'){
            $this->incidencias = Incidencia::all();
        }
        session()->flash('message', 'Incidencia creada exitosamente.');
        $this->resetFields();
        return redirect()->route('dashboard');
    }

    public function edit($id){
        $incidencia = Incidencia::findOrFail($id);
        $this->incidenciaId = $incidencia->id;
        $this->title = $incidencia->title;
        $this->descripcion = $incidencia->descripcion;
        $this->estado = $incidencia->estado;
        $this->asignado = $incidencia->asignado;
        session()->flash('message', "Editando incidencia ID: $id");

        $this->isModalOpen = true;



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
        $user = Auth::user();
        if($user->role === 'soporte'){
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        }elseif($user->role === 'administrador'){
            $this->incidencias = Incidencia::all();
        }

        return redirect()->route('dashboard');
    }

    public function delete($id){

        Incidencia::findOrFail($id)->delete();
        session()->flash('message', 'Incidencia eliminada exitosamente.');
        $user = Auth::user();
        if($user->role === 'soporte'){
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        }elseif($user->role === 'administrador'){
            $this->incidencias = Incidencia::all();
        }
        return redirect()->route('dashboard');
    }

    public function actualizaEstado(){

        $incidencia = Incidencia::findOrFail($this->incidenciaId);
        $incidencia->update(['estado' => $this->estado]);

        session()->flash('message', 'Estado de la incidencia actualizado');
        $this->changeStatus = false;
        $this->mount();
        return redirect()->route('dashboard');
    }

    public function asignarSoporte(){
        $incidencia = Incidencia::findOrFail($this->incidenciaId);
        //dd($this->asignado);

        if($this->asignado === ''){
            $incidencia->asignado_a()->dissociate();
        }else{
            $incidencia->asignado_a()->associate($this->asignado);

        }
        $incidencia->save();

        session()->flash('message', 'Soporte asignado exitosamente.');
        $user = Auth::user();
        if ($user->role === 'soporte') {
            $this->incidencias = Incidencia::where('asignado', $user->id)->get();
        } elseif ($user->role === 'administrador') {
            $this->incidencias = Incidencia::all();
        }
        $this->resetFields();
        return redirect()->route('dashboard');
    }
}
