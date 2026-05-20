<?php

namespace App\Models\Settings;

use App\Models\Peoples;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Companies extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'companies';

    protected $fillable = [
        'active',
        'people_id',
        'name',
        'nick',
        'code',
        'email',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'logo_path',
        'workload',
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
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }
    public function grade(): HasMany
    {
        return $this->hasMany(SchoolGrades::class, 'company_id', 'id')->where('active', 1);
    }
    public function grade_school(): BelongsTo
    {
        return $this->belongsTo(SchoolGrades::class,  'id', 'company_id')->where('active', 1);
    }
    public function comandant(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'people_id', 'id');
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
}
