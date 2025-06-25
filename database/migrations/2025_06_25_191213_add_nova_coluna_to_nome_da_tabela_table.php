<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fact_observeds', function (Blueprint $table) {
            $table->boolean('compliment')->nullable()->default(0);

            $table->foreignId('compliment_id')
                ->nullable()
                ->constrained('compliments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('fact_observeds', function (Blueprint $table) {
            $table->dropForeign(['compliment_id']);
            $table->dropColumn(['compliment', 'compliment_id']);
        });
    }
};
