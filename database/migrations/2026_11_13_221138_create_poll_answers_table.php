
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('poll_vote_id')
                ->constrained('poll_votes')
                ->cascadeOnDelete();

            $table->foreignId('poll_question_id')
                ->constrained('poll_questions')
                ->cascadeOnDelete();

            $table->foreignId('poll_option_id')
                ->nullable()
                ->constrained('poll_options')
                ->nullOnDelete();

            $table->text('answer_text')->nullable();

            $table->timestamps();

            $table->unique(
                ['poll_vote_id', 'poll_question_id', 'poll_option_id'],
                'poll_answers_unique_option'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_answers');
    }
};
