<?php

namespace App\Models\Settings;

use App\Models\Peoples;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolBattalionStudents extends Model
{

    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_battalion_students';

    protected $fillable = [
        'active',
        'people_id',
        'posto_grad',
        'school_battalions_id',
        'school_grades_id',
        'order',
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

    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'people_id', 'id');
    }
    public function grade(): BelongsTo
    {
        return $this->belongsTo(SchoolGrades::class, 'school_grades_id', 'id');
    }
}
