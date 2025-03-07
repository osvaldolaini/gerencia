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
        Schema::create('school_classes_students', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->nullable();
            $table->boolean('active')->nullable();
            $table->foreignId('school_classes_id')
                ->nullable()
                ->constrained('school_classes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('school_classes_year_id')
                ->nullable()
                ->constrained('school_classes_years')
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
        Schema::dropIfExists('school_classes_students');
    }
};
