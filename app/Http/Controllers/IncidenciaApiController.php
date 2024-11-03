<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenciaApiController extends Controller
{
    public function listIncidencias(Request $request)
    {

        $estado = $request->query('estado');

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

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

        return response()->json($incidencias);
    }
}
