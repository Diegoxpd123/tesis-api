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

           Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',250);
            $table->integer('evaluacionid');
            $table->string('respuesta',250);
            $table->string('opcion1',250);
            $table->string('opcion2',250);
            $table->string('opcion3',250);
            $table->string('opcion4',250);
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
        Schema::dropIfExists('preguntas');
    }
};
