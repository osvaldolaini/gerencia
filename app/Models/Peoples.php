<?php

namespace App\Models;

use App\Livewire\Settings\SchoolClasses\SchoolClassesStudents;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolClassesYears;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Peoples extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'peoples';

    protected $fillable = [
        'active',
        'name',
        'nick',
        'sex',
        'number',
        'logo_path',
        'type',
        'user_id',
        'posto_grad',
        'function',
        'grau',
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
                'name',
                'nick',
                'sex',
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

    public function getStudentTitleAttribute()
    {
        return $this->number . ' - ' . $this->nick;
    }
    public function getPeopleClassAttribute()
    {
        $studentClass = SchoolClassesStudent::where('active', 1)
            ->orderBy('created_at', 'asc')
            ->where('people_id', $this->id)->first();
        if ($studentClass) {
            return $studentClass->class->title . ' / ' . $studentClass->class->classYears->year;
        } else {
            return false;
        }
    }
    public function getAlClassAttribute()
    {
        $studentClass = SchoolClassesStudent::where('active', 1)
            ->orderBy('created_at', 'asc')
            ->where('people_id', $this->id)->first();
        if ($studentClass) {
            return $studentClass->class;
        } else {
            return false;
        }
    }
    public function getPeopleGradeAttribute()
    {
        $studentClass = SchoolClassesStudent::where('active', 1)
            ->orderBy('created_at', 'asc')
            ->where('people_id', $this->id)->first();
        if ($studentClass) {
            return $studentClass->class->school_grade_id;
        } else {
            return false;
        }
    }

    public function classT($school_classes)
    {
        $school_classes_year_id = SchoolClasses::find($school_classes)->classYears->id;
        $years = SchoolClassesYears::find($school_classes_year_id);
        $array = json_encode($years->classes->pluck('id'));
        $people_classes = SchoolClassesStudent::where('people_id', $this->id)->where('active', 1)->get();
        foreach ($people_classes as $class) {
            if (in_array($class->class->id, json_decode($array))) {
                $return = SchoolClasses::find($class->class->id);
                return $return->title;
            }
        }
        return false;
    }
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }
    public function setTitle()
    {
        return $this->nick . ' (Turma ' . $this->people_class . ')';
    }
}
