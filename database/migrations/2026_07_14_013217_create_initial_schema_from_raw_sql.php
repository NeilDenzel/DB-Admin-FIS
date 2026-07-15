<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $dbName = 'BD_SeguimientoAcademico_FIS';

        // 1. Crear la base de datos si no existe (conexión sin DB seleccionada)
        DB::connection('mysql_system')->statement(
            "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
        );

        // 2. Ejecutar DDL
        $ddlPath = database_path('sql/01_ddl.sql');
        if (file_exists($ddlPath)) {
            DB::connection('mysql')->unprepared(file_get_contents($ddlPath));
        }

        // 3. Ejecutar DML (datos iniciales)
        $dmlPath = database_path('sql/02_dml.sql');
        if (file_exists($dmlPath)) {
            DB::connection('mysql')->unprepared(file_get_contents($dmlPath));
        }

        // 4. Ejecutar triggers y stored procedures
        $spPath = database_path('sql/03_triggers_and_procedures.sql');
        if (file_exists($spPath)) {
            DB::connection('mysql')->unprepared(file_get_contents($spPath));
        }
    }

    public function down(): void
    {
        $dbName = 'BD_SeguimientoAcademico_FIS';
        DB::connection('mysql_system')->statement(
            "DROP DATABASE IF EXISTS `{$dbName}`"
        );
    }
};
