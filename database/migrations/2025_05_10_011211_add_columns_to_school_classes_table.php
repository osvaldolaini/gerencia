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
        Schema::table('school_classes', function (Blueprint $table) {
            $table->unsignedTinyInteger('rows')->default(5); // número de fileiras
            $table->unsignedTinyInteger('columns')->default(5); // número de colunas
            $table->enum('door_side', ['left', 'right'])->default('left'); // lado da porta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            //
        });
    }
};
