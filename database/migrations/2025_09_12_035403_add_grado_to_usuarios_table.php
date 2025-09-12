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
        // Campo 'grado' ya existe en la tabla usuarios
        // Esta migración documenta la adición del campo
        if (!Schema::hasColumn('usuarios', 'grado')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->integer('grado')->after('aludocenid');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('grado');
        });
    }
};
