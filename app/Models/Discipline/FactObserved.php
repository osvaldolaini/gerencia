<?php

namespace App\Models\Discipline;

use App\Models\Discipline\Settings\Faults;
use App\Models\Peoples;
use App\Models\Settings\Companies;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FactObserved extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'fact_observeds';


    protected $fillable = [
        'active',
        'number',
        'year',
        'cia',
        'company_id',
        'cmt_cia',
        'cmt_cia_posto',
        'people_id',
        'al_number',
        'al_nick',
        'al_name',
        'student_id',
        'al_class',
        'school_classes_id',
        'fact',
        'fact_hour',
        'fact_date',
        'fact_type',
        'faults',
        'fact_observer',
        'fact_observer_function',
        'fact_observer_id',
        'fafd',
        'fafd_id',
        'repeat_number',

        'sincomil_date',
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
                'cmt_cia',
                'al_nick',
                'fact_observer',
                'updated_by',
                'created_by',
            ]);
        });
        static::creating(function ($transaction) {
            $transaction->created_by = Auth::user()->name;
            $transaction->updated_by = Auth::user()->name;
            $transaction->fafd = 0;
            // Obtém o ano atual
            $anoAtual = now()->year;

            // Busca o maior número existente para o ano
            $ultimoNumero = static::where('year', $anoAtual)->max('number');

            // Define o próximo número (se não houver, começa em 1)
            $transaction->number = $ultimoNumero ? $ultimoNumero + 1 : 1;

            // Define o ano na transação
            $transaction->year = $anoAtual;
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

    public function getFactNumberAttribute()
    {
        return $this->number . '/' . $this->year;
    }


    //Json
    public function getJsonFaultsAttribute()
    {
        return json_decode($this->faults);
    }
    public function setFaultsAttribute($value)
    {
        $this->attributes['faults'] = json_encode($value);
    }

    public function setSincomilDateAttribute($value)
    {
        $this->attributes['sincomil_date'] = $this->dbDate($value);
    }
    public function getSimDateAttribute($value)
    {
        if ($value != "") {
            return $this->viewDate($value);
        }
    }
    public function setFactDateAttribute($value)
    {
        $this->attributes['fact_date'] = $this->dbDate($value);
    }
    public function getFDateAttribute()
    {
        return $this->viewDate($this->fact_date);
    }

    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
    public function observers(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'fact_observer_id', 'id');
    }
    public function fault(): BelongsTo
    {
        return $this->belongsTo(Faults::class, 'fault_id', 'id');
    }
    public function fafds(): BelongsTo
    {
        return $this->belongsTo(FaultDiscipline::class, 'fafd_id', 'id');
    }
    public function reincident($number, $date, $student_id)
    {
        $reincident = FactObserved::where('student_id', $student_id)
            ->where('faults', 'LIKE', '%' . $number . '%')
            ->where('fact_date', '<', $date)
            ->get()->count();
        return $reincident;
    }
}
