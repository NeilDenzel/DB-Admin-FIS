<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMallasController extends Controller
{
    public function index()
    {
        $mallas = DB::table('malla')->orderBy('anio_inicio')->paginate(15);
        return view('admin.mallas', compact('mallas'));
    }

    public function create()
    {
        return view('admin.malla-form', ['malla' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'        => 'required|max:30|unique:malla,nombre',
            'anio_inicio'   => 'required|integer|min:2000|max:2099',
            'anio_fin'      => 'nullable|integer|min:2000|max:2099',
            'vigente'       => 'nullable|boolean',
            'resolucion'    => 'nullable|max:80',
            'programa_pdf'  => 'nullable|max:255',
            'total_creditos'=> 'nullable|numeric|min:0',
            'descripcion'   => 'nullable|max:150',
        ]);

        $data['vigente'] = $request->boolean('vigente');

        DB::table('malla')->insert($data);

        return redirect('admin/mallas')->with('success', 'Malla creada correctamente.');
    }

    public function edit($id)
    {
        $malla = DB::table('malla')->where('id_malla', $id)->first();
        if (!$malla) abort(404);
        return view('admin.malla-form', compact('malla'));
    }

    public function update(Request $request, $id)
    {
        $malla = DB::table('malla')->where('id_malla', $id)->first();
        if (!$malla) abort(404);

        $data = $request->validate([
            'nombre'        => 'required|max:30|unique:malla,nombre,' . $id . ',id_malla',
            'anio_inicio'   => 'required|integer|min:2000|max:2099',
            'anio_fin'      => 'nullable|integer|min:2000|max:2099',
            'vigente'       => 'nullable|boolean',
            'resolucion'    => 'nullable|max:80',
            'programa_pdf'  => 'nullable|max:255',
            'total_creditos'=> 'nullable|numeric|min:0',
            'descripcion'   => 'nullable|max:150',
        ]);

        $data['vigente'] = $request->boolean('vigente');

        DB::table('malla')->where('id_malla', $id)->update($data);

        return redirect('admin/mallas')->with('success', 'Malla actualizada correctamente.');
    }

    public function destroy($id)
    {
        DB::table('malla')->where('id_malla', $id)->delete();
        return redirect('admin/mallas')->with('success', 'Malla eliminada correctamente.');
    }
}
