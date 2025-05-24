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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->foreignId('student_contacts_id')
                ->nullable()
                ->constrained('student_contacts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('to')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->string('attachment')->nullable();
            /*Log */
            $table->timestamps();
            $table->string('created_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
