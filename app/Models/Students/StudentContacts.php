<?php

namespace App\Models\Students;

use App\Models\Emails;
use App\Models\Peoples;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class StudentContacts extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'student_contacts';

    protected $fillable = [
        'active',
        'student_id',
        'type',
        'parent',
        'contact',
        'code',
        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'parent',
                'updated_by',
                'created_by',
            ]);
        });
        static::creating(function ($transaction) {
            $transaction->created_by = Auth::user()->name;
            $transaction->updated_by = Auth::user()->name;
        });

        static::updating(function ($transaction) {
            $transaction->updated_by = Auth::user()->name;
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

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id')->where('active', 1);
    }
    public function emails(): HasMany
    {
        return $this->hasMany(Emails::class, 'student_contacts_id', 'id');
    }
}
