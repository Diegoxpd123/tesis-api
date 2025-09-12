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
        // Campos 'tiemporeforzamiento' e 'isexamen' ya existen en la tabla resultadospreguntas
        // Esta migración documenta la adición de los campos
        if (!Schema::hasColumn('resultadospreguntas', 'tiemporeforzamiento')) {
            Schema::table('resultadospreguntas', function (Blueprint $table) {
                $table->integer('tiemporeforzamiento')->after('tiempo');
                $table->integer('isexamen')->after('tiemporeforzamiento');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resultadospreguntas', function (Blueprint $table) {
            $table->dropColumn(['tiemporeforzamiento', 'isexamen']);
        });
    }
};
