<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollAnswer extends Model
{
    protected $table = 'poll_answers';

    protected $fillable = [
        'poll_vote_id',
        'poll_question_id',
        'poll_option_id',
        'answer_text',
    ];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(PollVote::class, 'poll_vote_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class, 'poll_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(PollOption::class, 'poll_option_id');
    }
}
