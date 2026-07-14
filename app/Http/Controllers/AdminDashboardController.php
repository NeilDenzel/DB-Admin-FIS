<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $cursos = DB::table('curso')
            ->join('situacion_academica', 'curso.cod_curso', '=', 'situacion_academica.cod_curso')
            ->where(function ($q) {
                $q->where('situacion_academica.desea_llevar', '=', 'Si')
                  ->orWhereIn('situacion_academica.id_estado', [2, 4]);
            })
            ->select(
                'curso.cod_curso',
                'curso.nombre',
                'curso.ciclo',
                DB::raw('COUNT(situacion_academica.cod_estudiante) as total_interesados')
            )
            ->groupBy('curso.cod_curso', 'curso.nombre', 'curso.ciclo')
            ->orderByDesc('total_interesados')
            ->get();

        return view('admin.dashboard', compact('cursos'));
    }
}
