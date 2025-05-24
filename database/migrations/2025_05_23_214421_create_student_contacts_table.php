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
        Schema::create('student_contacts', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('type')->nullable();
            $table->string('parent')->nullable();
            $table->string('contact')->nullable();
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
        Schema::dropIfExists('student_contacts');
    }
};
