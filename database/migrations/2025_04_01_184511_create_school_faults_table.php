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
        Schema::create('school_faults', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('companies_id')
                ->nullable()
                ->constrained('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('school_grades_id')
                ->nullable()
                ->constrained('school_grades')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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

            $table->date('date')->nullable();
            $table->integer('qtd')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('school_faults');
    }
};
