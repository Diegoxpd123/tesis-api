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
          Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('usuario',100);
            $table->string('contra',100);
            $table->integer('tipousuarioid');
            $table->integer('aludocenid');
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
        Schema::dropIfExists('usuarios');
    }
};
