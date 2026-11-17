<?php

namespace App\Models\Polls;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

class Poll extends Model
{
    use HasFactory, LogsActivity;
    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    protected $table = 'polls';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($poll) {

            $slug = Str::slug($poll->title);

            $originalSlug = $slug;
            $count = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $poll->slug = $slug;
        });
        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'title',
            ]);
        });

        static::creating(function ($transaction) {
            $transaction->created_by = Auth::user()->id;
            $transaction->updated_by = Auth::user()->id;
        });
    }
    public function setUpperCaseAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->attributes[$attribute] = mb_strtoupper($this->attributes[$attribute]);
            }
        }
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PollQuestion::class)
            ->orderBy('order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    public function getRouteKeyName(): string
    {
        return auth()->check() ? 'id' : 'slug';
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->active
            && (!$this->start_date || now()->greaterThanOrEqualTo($this->start_date))
            && (!$this->end_date || now()->lessThanOrEqualTo($this->end_date));
    }
}
