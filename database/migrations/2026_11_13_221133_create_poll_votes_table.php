
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('poll_id')
                ->constrained('polls')
                ->cascadeOnDelete();

            $table->foreignId('people_id')
                ->nullable()
                ->constrained('peoples')
                ->nullOnDelete();

            // Student identification snapshot
            $table->string('student_name');
            $table->string('student_number', 30);

            $table->foreignId('school_class_id')
                ->nullable()
                ->constrained('school_classes')
                ->nullOnDelete();

            $table->string('school_class_name')->nullable();

            $table->timestamp('voted_at')->useCurrent();

            $table->timestamps();

            // One vote per student in each poll
            $table->unique(
                ['poll_id', 'people_id'],
                'poll_votes_unique_student'
            );

            $table->index(['poll_id', 'student_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};
