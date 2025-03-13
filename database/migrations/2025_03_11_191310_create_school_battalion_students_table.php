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
        Schema::create('school_battalion_students', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->nullable();
            $table->boolean('active')->nullable();
            $table->string('posto_grad', 50)->nullable();
            $table->foreignId('school_grades_id')
                ->nullable()
                ->constrained('school_grades')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('school_battalions_id')
                ->nullable()
                ->constrained('school_battalions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('people_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_battalion_students');
    }
};
