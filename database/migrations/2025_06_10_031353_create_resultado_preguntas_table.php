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
         Schema::create('resultadospreguntas', function (Blueprint $table) {
            $table->id();
            $table->integer('alumnoid');
            $table->integer('preguntaid');
            $table->integer('cursoid');
            $table->integer('temaid');
            $table->integer('institucionid');
            $table->string('respuesta',250);
            $table->integer('tiempo');
            $table->date('created_at');
            $table->date('updated_at');
            $table->integer('is_deleted');
            $table->integer('is_actived');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_preguntas');
    }
};
