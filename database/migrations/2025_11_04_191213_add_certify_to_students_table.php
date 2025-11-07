<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peoples', function (Blueprint $table) {
            $table->string('mom')->nullable();
            $table->string('dad')->nullable();
            $table->string('city_birth')->nullable();
            $table->string('state_birth')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peoples', function (Blueprint $table) {
            $table->dropColumn(['mom', 'dad', 'city_birth', 'state_birth']);
        });
    }
};
