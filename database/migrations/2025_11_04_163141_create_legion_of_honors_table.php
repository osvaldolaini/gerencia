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
        Schema::create('legion_of_honors', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->string('local')->nullable();
            $table->year('year')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('bi_date')->nullable();
            $table->string('bi_number')->nullable();
            $table->string('supplement_number')->nullable();
            $table->string('bi_text')->nullable();

            $table->date('off_bi_date')->nullable();
            $table->string('off_bi_number')->nullable();
            $table->string('off_supplement_number')->nullable();
            $table->string('off_bi_text')->nullable();

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
        Schema::dropIfExists('legion_of_honors');
    }
};
