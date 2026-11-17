<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PollOption extends Model
{
    use HasFactory, LogsActivity;
    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $table = 'poll_options';

    protected $fillable = [
        'poll_question_id',
        'option',
        'order',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class, 'poll_question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
