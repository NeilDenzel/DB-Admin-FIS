<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminReportesController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT * FROM vw_EstudiantesRezago ORDER BY cod_estudiante, cod_curso');

        $rezago = [];
        foreach ($rows as $r) {
            $cod = $r->cod_estudiante;
            if (!isset($rezago[$cod])) {
                $rezago[$cod] = [
                    'cod_estudiante' => $cod,
                    'apellidos'      => $r->apellidos,
                    'nombres'        => $r->nombres,
                    'cursos'         => [],
                ];
            }
            $rezago[$cod]['cursos'][] = [
                'cod_curso' => $r->cod_curso,
                'curso'     => $r->curso,
                'estado'    => $r->estado,
            ];
        }
        $rezago = array_values($rezago);

        return view('admin.reportes', compact('rezago'));
    }

    public function exportPdf()
    {
        $rows = DB::select('SELECT * FROM vw_EstudiantesRezago ORDER BY cod_estudiante, cod_curso');

        $rezago = [];
        foreach ($rows as $r) {
            $cod = $r->cod_estudiante;
            if (!isset($rezago[$cod])) {
                $rezago[$cod] = [
                    'cod_estudiante' => $cod,
                    'apellidos'      => $r->apellidos,
                    'nombres'        => $r->nombres,
                    'cursos'         => [],
                ];
            }
            $rezago[$cod]['cursos'][] = [
                'cod_curso' => $r->cod_curso,
                'curso'     => $r->curso,
                'estado'    => $r->estado,
            ];
        }
        $rezago = array_values($rezago);

        $pdf = Pdf::loadView('admin.reportes-pdf', compact('rezago'));
        return $pdf->download('reporte-rezago-academico.pdf');
    }
}
