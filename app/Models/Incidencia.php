<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'descripcion',
        'estado',
        'creado',
        'asignado',
    ];


    const STATUS_TODO = 'To Do';
    const STATUS_DOING = 'Doing';
    const STATUS_DONE = 'Done';

    public function creador(){
        return $this->belongsTo(User::class, 'creado');
    }

    public function asignado_a(){
        return $this->belongsTo(User::class, 'asignado');
    }


}
