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
        // Campo 'grado' ya existe en la tabla alumnos
        // Esta migración documenta la adición del campo
        if (!Schema::hasColumn('alumnos', 'grado')) {
            Schema::table('alumnos', function (Blueprint $table) {
                $table->integer('grado')->after('institucionid');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('grado');
        });
    }
};
