<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Enums\PollQuestionType;

class PollQuestion extends Model
{
    use HasFactory, LogsActivity;
    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $table = 'poll_questions';

    protected $fillable = [
        'poll_id',
        'description',
        'type',
        'required',
        'order',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'order' => 'integer',
            'active' => 'boolean',
            'type' => PollQuestionType::class,
        ];
    }
    public function getRequiredLabelAttribute()
    {
        return $this->required ? 'Obrigatório' : 'Opcional';
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class)
            ->orderBy('order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
