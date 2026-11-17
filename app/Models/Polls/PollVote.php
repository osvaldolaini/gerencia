<?php

namespace App\Models\Polls;

use App\Models\Peoples;
use App\Models\Settings\SchoolClasses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollVote extends Model
{

    protected $table = 'poll_votes';

    protected $fillable = [
        'poll_id',
        'people_id',
        'student_name',
        'student_number',
        'school_class_id',
        'school_class_name',
        'voted_at',
    ];

    protected function casts(): array
    {
        return [
            'voted_at' => 'datetime',
        ];
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function people(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'people_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClasses::class, 'school_class_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
