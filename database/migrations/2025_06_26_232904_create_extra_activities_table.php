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
        Schema::create('extra_activities', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('extra_modalities_id')
                ->nullable()
                ->constrained('extra_modalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('extra_activities');
    }
};
