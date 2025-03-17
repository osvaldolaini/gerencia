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
        Schema::table('peoples', function (Blueprint $table) {

            $table->string('function')->nullable();
            $table->string('posto_grad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peoples', function (Blueprint $table) {
            // Verifique se as colunas existem antes de tentar removê-las

            if (Schema::hasColumn('peoples', 'function')) {
                $table->dropColumn('function');
            }
            if (Schema::hasColumn('peoples', 'posto_grad')) {
                $table->dropColumn('posto_grad');
            }
        });
    }
};
