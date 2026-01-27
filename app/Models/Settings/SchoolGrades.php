<?php

namespace App\Models\Settings;

use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolGrades extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_grades';

    protected $fillable = [
        'active',
        'name',
        'company_id',
        'nick',
        'code',
        'logo_path',
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
                'name',
                'nick',
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

    public function classes($school_classes_year_id)
    {
        $classes = SchoolClasses::where('active', 1)->where('school_classes_year_id', $school_classes_year_id)
            ->where('school_grade_id', $this->id)->get();
        return $classes;
    }
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
    public function getCompany(): HasOne
    {
        return $this->hasOne(Companies::class,  'id', 'company_id');
    }
    public function battalion(): HasMany
    {
        return $this->hasMany(SchoolBattalionStudents::class, 'school_grades_id', 'id');
    }
    public function getClasses(): HasMany
    {
        $actived = SchoolClassesYears::where("active", 1)->first()->id;
        return $this->hasMany(SchoolClasses::class, 'school_grade_id', 'id')->where('school_classes_year_id', $actived);
    }

    public function students_live($school_classes_year_id)
    {
        $grades = $this;
        $class = [];

        foreach ($grades->getClasses->pluck('id')->toArray() as $item) {
            $class[] = $item;
        }

        $students = SchoolClassesStudent::where('active', 1)
            ->where('school_classes_year_id', $school_classes_year_id)
            ->whereIn('school_classes_id', $class)->get();
        return $students->count();
    }
}
