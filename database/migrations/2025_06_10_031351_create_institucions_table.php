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

        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
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
        Schema::dropIfExists('institucions');
    }
};
