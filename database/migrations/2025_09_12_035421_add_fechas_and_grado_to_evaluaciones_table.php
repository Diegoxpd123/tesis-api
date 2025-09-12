<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Campos 'fechainicio', 'fechafin' y 'grado' ya existen en la tabla evaluaciones
        // Esta migración documenta la adición de los campos
        if (!Schema::hasColumn('evaluaciones', 'fechainicio')) {
            Schema::table('evaluaciones', function (Blueprint $table) {
                $table->date('fechainicio')->after('institucionid');
                $table->date('fechafin')->after('fechainicio');
                $table->integer('grado')->after('fechafin');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->dropColumn(['fechainicio', 'fechafin', 'grado']);
        });
    }
};
