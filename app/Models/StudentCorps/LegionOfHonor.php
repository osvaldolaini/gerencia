<?php

namespace App\Models\StudentCorps;

use Illuminate\Database\Eloquent\Model;

use App\Models\Peoples;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasAttributeConversions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LegionOfHonor extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'legion_of_honors';

    protected $fillable = [
        'active',
        'student_id',
        'local',
        'year',
        'code',
        'bi_date',
        'bi_text',
        'bi_number',
        'supplement_number',
        'off_bi_date',
        'off_bi_text',
        'off_bi_number',
        'off_supplement_number',
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
                'local',
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
    public function setBiDateAttribute($value)
    {
        $this->attributes['bi_date'] = $this->dbDate($value);
    }
    public function getBDateAttribute()
    {
        if ($this->bi_date != "") {
            return $this->viewDate($this->bi_date);
        }
    }
    public function setOffBiDateAttribute($value)
    {
        $this->attributes['off_bi_date'] = $this->dbDate($value);
    }
    public function getOffBDateAttribute()
    {
        if ($this->off_bi_date != "") {
            return $this->viewDate($this->off_bi_date);
        }
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id');
    }
}
