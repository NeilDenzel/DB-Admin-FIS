<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $spPath = database_path('sql/03_triggers_and_procedures.sql');
        if (file_exists($spPath)) {
            DB::connection('mysql')->unprepared(file_get_contents($spPath));
        }
    }

    public function down(): void
    {
        DB::connection('mysql')->statement('DROP TRIGGER IF EXISTS trg_Estudiante_AsignarMalla');
        DB::connection('mysql')->statement('DROP TRIGGER IF EXISTS trg_FechaRegistro');
        DB::connection('mysql')->statement('DROP PROCEDURE IF EXISTS sp_RegistrarSituacionAcademica');
        DB::connection('mysql')->statement('DROP PROCEDURE IF EXISTS sp_BuscarEstudiante');
        DB::connection('mysql')->statement('DROP FUNCTION IF EXISTS fn_TotalCursosPendientes');
        DB::connection('mysql')->statement('DROP VIEW IF EXISTS vw_EstudiantesRezago');
    }
};
