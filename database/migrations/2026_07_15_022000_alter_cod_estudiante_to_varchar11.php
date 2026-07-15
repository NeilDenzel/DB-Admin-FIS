<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('ALTER TABLE estudiante MODIFY cod_estudiante VARCHAR(11) NOT NULL');
        DB::statement('ALTER TABLE situacion_academica MODIFY cod_estudiante VARCHAR(11) NOT NULL');
        DB::statement('ALTER TABLE matricula MODIFY cod_estudiante VARCHAR(11) NOT NULL');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('ALTER TABLE estudiante MODIFY cod_estudiante VARCHAR(15) NOT NULL');
        DB::statement('ALTER TABLE situacion_academica MODIFY cod_estudiante VARCHAR(15) NOT NULL');
        DB::statement('ALTER TABLE matricula MODIFY cod_estudiante VARCHAR(15) NOT NULL');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
