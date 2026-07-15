<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalEstudiantes = DB::table('estudiante')->count();
        $totalCursos = DB::table('curso')->count();
        $totalMallas = DB::table('malla')->count();
        $totalRezago = DB::selectOne('SELECT COUNT(*) AS total FROM vw_EstudiantesRezago')->total;

        return view('admin.dashboard', compact(
            'totalEstudiantes', 'totalCursos', 'totalMallas', 'totalRezago'
        ));
    }
}
