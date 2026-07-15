<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPrerrequisitosController extends Controller
{
    public function index()
    {
        $prerrequisitos = DB::table('prerrequisito')
            ->join('curso as c1', 'prerrequisito.cod_curso', '=', 'c1.cod_curso')
            ->join('curso as c2', 'prerrequisito.cod_prerrequisito', '=', 'c2.cod_curso')
            ->select(
                'prerrequisito.id_prerrequisito',
                'prerrequisito.cod_curso',
                'c1.nombre as curso_nombre',
                'c1.ciclo as curso_ciclo',
                'prerrequisito.cod_prerrequisito',
                'c2.nombre as prerreq_nombre',
                'c2.ciclo as prerreq_ciclo'
            )
            ->orderBy('c1.ciclo')
            ->orderBy('c1.nombre')
            ->paginate(15);

        $cursos = DB::table('curso')->orderBy('ciclo')->orderBy('nombre')->get();

        return view('admin.prerrequisitos', compact('prerrequisitos', 'cursos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_curso'         => 'required|string|exists:curso,cod_curso',
            'cod_prerrequisito' => 'required|string|exists:curso,cod_curso|different:cod_curso',
        ]);

        $exists = DB::table('prerrequisito')
            ->where('cod_curso', $data['cod_curso'])
            ->where('cod_prerrequisito', $data['cod_prerrequisito'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['cod_prerrequisito' => 'Este prerrequisito ya está registrado.']);
        }

        DB::table('prerrequisito')->insert($data);

        return redirect('admin/prerrequisitos')->with('success', 'Prerrequisito asignado correctamente.');
    }

    public function destroy($id)
    {
        DB::table('prerrequisito')->where('id_prerrequisito', $id)->delete();
        return redirect('admin/prerrequisitos')->with('success', 'Prerrequisito eliminado correctamente.');
    }
}
