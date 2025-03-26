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
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('type');
            $table->decimal('grau', $precision = 10, $scale = 2)->nullable();
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('logo_path', 100)->nullable();
            $table->string('nick')->nullable();
            $table->string('sex')->nullable();
            $table->string('code')->nullable();

            $table->string('function')->nullable();
            $table->string('posto_grad')->nullable();
            /*Log */
            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peoples');
    }
};
