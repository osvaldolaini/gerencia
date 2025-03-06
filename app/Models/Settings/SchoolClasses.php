<?php

namespace App\Models\Settings;

use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolClasses extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_classes';

    protected $fillable = [
        'active',
        'title',
        'school_classes_year_id',
        'school_grade_id',
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


    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = $value;
        if ($value == 0) {
            $this->order = 99999;
            $this->save();
        } else {
            if ($this->school_classes_year_id) {
                $last = $this->where('school_classes_year_id', $this->school_classes_year_id)->orderBy('order', 'desc')
                    ->first();
                $this->order = $last->order + 1;
                $this->save();
            }
        }
    }
}
