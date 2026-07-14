<?php

namespace App\Http\Controllers;

class AdminElectivosController extends Controller
{
    public function index()
    {
        return view('admin.electivos');
    }
}
