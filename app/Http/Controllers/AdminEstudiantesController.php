<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminEstudiantesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $ciclo = $request->get('ciclo');
        $id_malla = $request->get('id_malla');

        $estudiantes = DB::table('estudiante')
            ->leftJoin('malla', 'estudiante.id_malla', '=', 'malla.id_malla')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('estudiante.cod_estudiante', 'like', "%{$search}%")
                      ->orWhere('estudiante.nombres', 'like', "%{$search}%")
                      ->orWhere('estudiante.apellidos', 'like', "%{$search}%");
                });
            })
            ->when($ciclo, fn($q) => $q->where('estudiante.ciclo_actual', $ciclo))
            ->when($id_malla, fn($q) => $q->where('estudiante.id_malla', $id_malla))
            ->select(
                'estudiante.cod_estudiante',
                'estudiante.dni',
                'estudiante.nombres',
                'estudiante.apellidos',
                'estudiante.correo',
                'estudiante.telefono',
                'estudiante.ciclo_actual',
                'malla.nombre as malla_nombre',
                'malla.id_malla as malla_id'
            )
            ->orderBy('estudiante.ciclo_actual')
            ->orderBy('estudiante.apellidos')
            ->paginate(15);

        $mallas = DB::table('malla')->orderBy('nombre')->get();
        $ciclos = range(1, 10);

        return view('admin.estudiantes', compact('estudiantes', 'mallas', 'ciclos', 'search', 'ciclo', 'id_malla'));
    }

    public function create()
    {
        $mallas = DB::table('malla')->orderBy('nombre')->get();
        return view('admin.estudiante-form', ['estudiante' => null, 'mallas' => $mallas]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_estudiante' => 'required|max:11|unique:estudiante,cod_estudiante',
            'dni'            => 'required|digits:8|unique:estudiante,dni',
            'nombres'        => 'required|max:80',
            'apellidos'      => 'required|max:80',
            'correo'         => 'nullable|max:120',
            'telefono'       => 'nullable|max:20',
            'sexo'           => 'nullable|in:M,F,O',
            'ciclo_actual'   => 'nullable|integer|between:1,10',
            'id_malla'       => 'nullable|integer|exists:malla,id_malla',
        ]);

        DB::table('estudiante')->insert($data);

        return redirect('admin/estudiantes/' . $data['cod_estudiante'])
            ->with('success', 'Estudiante creado correctamente.');
    }

    public function show($cod_estudiante)
    {
        $estudiante = DB::table('estudiante')
            ->leftJoin('malla', 'estudiante.id_malla', '=', 'malla.id_malla')
            ->where('estudiante.cod_estudiante', $cod_estudiante)
            ->select(
                'estudiante.cod_estudiante',
                'estudiante.dni',
                'estudiante.nombres',
                'estudiante.apellidos',
                'estudiante.correo',
                'estudiante.telefono',
                'estudiante.sexo',
                'estudiante.ciclo_actual',
                'estudiante.id_malla',
                'malla.nombre as malla_nombre'
            )
            ->first();

        if (!$estudiante) {
            abort(404, 'Estudiante no encontrado');
        }

        $situacion = DB::table('curso')
            ->join('situacion_academica', 'curso.cod_curso', '=', 'situacion_academica.cod_curso')
            ->join('estado_academico', 'situacion_academica.id_estado', '=', 'estado_academico.id_estado')
            ->where('situacion_academica.cod_estudiante', $cod_estudiante)
            ->select(
                'curso.cod_curso',
                'curso.nombre',
                'curso.ciclo',
                'curso.creditos',
                'estado_academico.nombre as estado',
                'situacion_academica.desea_llevar',
                'situacion_academica.prioridad'
            )
            ->orderBy('curso.ciclo')
            ->orderBy('curso.nombre')
            ->get();

        $matriculas = DB::table('detalle_matricula')
            ->join('matricula', 'detalle_matricula.id_matricula', '=', 'matricula.id_matricula')
            ->join('periodo', 'matricula.id_periodo', '=', 'periodo.id_periodo')
            ->join('curso', 'detalle_matricula.cod_curso', '=', 'curso.cod_curso')
            ->where('matricula.cod_estudiante', $cod_estudiante)
            ->select(
                'curso.cod_curso',
                'curso.nombre',
                'curso.ciclo',
                'periodo.nombre as periodo',
                'detalle_matricula.nota_final',
                'detalle_matricula.aprobado',
                'detalle_matricula.numero_matricula'
            )
            ->orderBy('periodo.nombre')
            ->orderBy('curso.ciclo')
            ->get();

        return view('admin.estudiante-show', compact('estudiante', 'situacion', 'matriculas'));
    }

    public function edit($cod_estudiante)
    {
        $estudiante = DB::table('estudiante')->where('cod_estudiante', $cod_estudiante)->first();
        if (!$estudiante) {
            abort(404);
        }
        $mallas = DB::table('malla')->orderBy('nombre')->get();
        return view('admin.estudiante-form', compact('estudiante', 'mallas'));
    }

    public function update(Request $request, $cod_estudiante)
    {
        $estudiante = DB::table('estudiante')->where('cod_estudiante', $cod_estudiante)->first();
        if (!$estudiante) {
            abort(404);
        }

        $data = $request->validate([
            'dni'          => 'required|digits:8|unique:estudiante,dni,' . $cod_estudiante . ',cod_estudiante',
            'nombres'      => 'required|max:80',
            'apellidos'    => 'required|max:80',
            'correo'       => 'nullable|max:120',
            'telefono'     => 'nullable|max:20',
            'sexo'         => 'nullable|in:M,F,O',
            'ciclo_actual' => 'nullable|integer|between:1,10',
            'id_malla'     => 'nullable|integer|exists:malla,id_malla',
        ]);

        DB::table('estudiante')->where('cod_estudiante', $cod_estudiante)->update($data);

        return redirect('admin/estudiantes/' . $cod_estudiante)
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    public function showImportForm()
    {
        return view('admin.estudiantes-importar');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $import = new EstudiantesImport();
        Excel::import($import, $request->file('archivo'));

        $successCount = $import->getRowCount();
        $failures = $import->failures();

        $message = "{$successCount} estudiantes importados correctamente.";
        if ($failures->count() > 0) {
            $message .= " {$failures->count()} filas omitidas por errores de validación.";
            $firstErrors = $failures->take(3);
            $message .= " Ejemplos: ";
            foreach ($firstErrors as $fe) {
                $message .= "[Fila {$fe->row()}: " . implode(', ', $fe->errors()) . "] ";
            }
        }

        return back()->with('success', $message);
    }
}
