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
        Schema::create('fact_observeds', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->integer('number')->nullable();
            $table->integer('year')->nullable();
            $table->string('cia')->nullable();
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('cmt_cia')->nullable();
            $table->string('cmt_cia_posto')->nullable();
            $table->foreignId('people_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('al_number')->nullable();
            $table->string('al_nick')->nullable();
            $table->string('al_name')->nullable();
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('al_class')->nullable();
            $table->foreignId('school_classes_id')
                ->nullable()
                ->constrained('school_classes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->mediumText('fact')->nullable();
            $table->time('fact_hour')->nullable();
            $table->date('fact_date')->nullable();
            $table->string('fact_type')->nullable();
            $table->string('faults')->nullable();
            $table->string('fact_observer')->nullable();
            $table->string('fact_observer_function')->nullable();
            $table->foreignId('fact_observer_id')
                ->nullable()
                ->constrained('peoples')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->boolean('repeat')->nullable();
            $table->integer('repeat_number')->nullable();

            $table->boolean('fafd')->nullable();
            $table->foreignId('fafd_id')
                ->nullable()
                ->constrained('fault_disciplines')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->boolean('compliment')->nullable();
            $table->foreignId('compliment_id')
                ->nullable()
                ->constrained('compliments')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->date('sincomil_date')->nullable();

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
        Schema::dropIfExists('fact_observeds');
    }
};
