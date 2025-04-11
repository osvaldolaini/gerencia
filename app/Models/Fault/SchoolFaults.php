<?php

namespace App\Models\Fault;

use App\Models\Peoples;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolFaults extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_faults';

    protected $fillable = [
        'active',
        'justified',
        'logo_path',
        'text',
        'student_id',
        'companies_id',
        'school_grades_id',
        'school_classes_id',
        'school_classes_year_id',
        'date',
        'qtd',
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
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $this->dbDate($value);
    }
    public function getDateViewAttribute()
    {
        return $this->viewDate($this->date);
    }

    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id');
    }
    public function companies(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'companies_id', 'id');
    }
    public function grades(): BelongsTo
    {
        return $this->belongsTo(SchoolGrades::class, 'school_grades_id', 'id');
    }
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClasses::class, 'school_classes_id', 'id');
    }
    public function class_year(): BelongsTo
    {
        return $this->belongsTo(SchoolClassesYears::class, 'school_classes_year_id', 'id');
    }

    public function scopeFilterFields($query, $filters)
    {
        foreach ($filters as $key => $value) {

            if ($key == 'date') {
                if (substr_count($value, " ") === 1) {
                    $partesSpace = explode(" ", $value);
                    if (substr_count($partesSpace[0], "/") === 1) {
                        $partes = explode("/", $partesSpace[0]);
                        $converted = $partes[1] . "%-" . $partes[0] . "% " . $partesSpace[1];
                    } elseif (substr_count($partesSpace[0], "/") === 2) {
                        $partes = explode("/", $partesSpace[0]);
                        $converted = $partes[2] . "%-" . $partes[1] . "-" . $partes[0] . "% " . $partesSpace[1];
                    } else {
                        $converted = $value;
                    }
                } else {
                    if (substr_count($value, "/") === 1) {
                        $partes = explode("/", $value);
                        $converted = $partes[1] . "%-" . $partes[0];
                    } elseif (substr_count($value, "/") === 2) {
                        $partes = explode("/", $value);
                        $converted = $partes[2] . "%-" . $partes[1] . "-" . $partes[0];
                    } else {
                        $converted = $value;
                    }
                }
                return array('f' => 'LIKE', 'converted' => '%' . $converted . '%');
            }
        }
    }
}
