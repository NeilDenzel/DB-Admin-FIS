<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCursosController extends Controller
{
    public function index()
    {
        $cursos = DB::table('curso')
            ->leftJoin('malla', 'curso.id_malla', '=', 'malla.id_malla')
            ->select('curso.*', 'malla.nombre as malla_nombre')
            ->orderBy('curso.ciclo')
            ->orderBy('curso.nombre')
            ->paginate(15);

        return view('admin.cursos', compact('cursos'));
    }

    public function create()
    {
        $mallas = DB::table('malla')->orderBy('nombre')->get();
        return view('admin.curso-form', ['curso' => null, 'mallas' => $mallas]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_curso'     => 'required|max:15|unique:curso,cod_curso',
            'nombre'        => 'required|max:120',
            'ciclo'         => 'required|integer|between:1,10',
            'creditos'      => 'required|numeric|min:0|max:30',
            'horas_teoria'  => 'nullable|integer|min:0',
            'horas_practica'=> 'nullable|integer|min:0',
            'tipo'          => 'required|in:Obligatorio,Electivo',
            'id_malla'      => 'required|integer|exists:malla,id_malla',
        ]);

        $data['horas_teoria'] = $data['horas_teoria'] ?? 0;
        $data['horas_practica'] = $data['horas_practica'] ?? 0;

        DB::table('curso')->insert($data);

        return redirect('admin/cursos')->with('success', 'Curso creado correctamente.');
    }

    public function edit($cod_curso)
    {
        $curso = DB::table('curso')->where('cod_curso', $cod_curso)->first();
        if (!$curso) abort(404);
        $mallas = DB::table('malla')->orderBy('nombre')->get();
        return view('admin.curso-form', compact('curso', 'mallas'));
    }

    public function update(Request $request, $cod_curso)
    {
        $curso = DB::table('curso')->where('cod_curso', $cod_curso)->first();
        if (!$curso) abort(404);

        $data = $request->validate([
            'nombre'        => 'required|max:120',
            'ciclo'         => 'required|integer|between:1,10',
            'creditos'      => 'required|numeric|min:0|max:30',
            'horas_teoria'  => 'nullable|integer|min:0',
            'horas_practica'=> 'nullable|integer|min:0',
            'tipo'          => 'required|in:Obligatorio,Electivo',
            'id_malla'      => 'required|integer|exists:malla,id_malla',
        ]);

        $data['horas_teoria'] = $data['horas_teoria'] ?? 0;
        $data['horas_practica'] = $data['horas_practica'] ?? 0;

        DB::table('curso')->where('cod_curso', $cod_curso)->update($data);

        return redirect('admin/cursos')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy($cod_curso)
    {
        DB::table('curso')->where('cod_curso', $cod_curso)->delete();
        return redirect('admin/cursos')->with('success', 'Curso eliminado correctamente.');
    }
}
