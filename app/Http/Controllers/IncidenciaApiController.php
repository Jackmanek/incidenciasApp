<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenciaApiController extends Controller
{
    public function listIncidencias(Request $request)
    {
        // Obtiene el estado a filtrar de la consulta
        $estado = $request->query('estado');

        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Filtrado según el rol del usuario
        if ($user->role === 'administrador') {
            $incidencias = Incidencia::when($estado, function ($query) use ($estado) {
                return $query->where('estado', $estado);
            })->get();
        } elseif ($user->role === 'soporte') {
            $incidencias = Incidencia::where('asignado', $user->id)
                ->when($estado, function ($query) use ($estado) {
                    return $query->where('estado', $estado);
                })->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Retorna la colección de incidencias
        return response()->json($incidencias);
    }
}
