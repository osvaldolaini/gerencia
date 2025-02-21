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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();

            $table->string('cpf_cnpj')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();

            $table->string('board')->nullable();

            $table->string('airfield_codigoOaci')->nullable();
            $table->string('airfield_ciad')->nullable();
            $table->string('airfield_name')->nullable();
            $table->string('airfield_city')->nullable();
            $table->string('airfield_state')->nullable();

            $table->string('logo_path', 100)->nullable();

            $table->string('emails')->nullable();
            $table->string('contacts')->nullable();

            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
