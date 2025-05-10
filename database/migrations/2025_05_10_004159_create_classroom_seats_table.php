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
        Schema::create('classroom_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_classes_id')
                ->nullable()
                ->constrained('school_classes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('row'); // linha (ex: 1 a 5)
            $table->integer('column'); // coluna (ex: 1 a 5)
            $table->foreignId('people_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('classroom_seats');
    }
};
