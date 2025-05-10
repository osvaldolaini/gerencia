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

class ClassroomSeats extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'classroom_seats';

    protected $fillable = [
        'active',
        'people_id',
        'school_classes_id',
        'row',
        'column',
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
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }

    public function students_live($school_classes_year_id)
    {
        $grades = $this->grade;
        $class = [];
        foreach ($grades as $grade) {
            // $class = $grade->getClasses->pluck('id')->toArray();
            foreach ($grade->getClasses->pluck('id')->toArray() as $item) {
                $class[] = $item;
            }
        }

        $students = SchoolClassesStudent::where('active', 1)
            ->where('school_classes_year_id', $school_classes_year_id)
            ->whereIn('school_classes_id', $class)->get();
        return $students->count();
    }
    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'people_id', 'id');
    }
}
