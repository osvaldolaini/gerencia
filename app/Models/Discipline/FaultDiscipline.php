<?php

namespace App\Models\Discipline;

use App\Models\Discipline\Settings\Faults;
use App\Models\Peoples;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Support\Carbon;
use App\Enums\Penalty;
use App\Models\Settings\SchoolClassesYears;

class FaultDiscipline extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'fault_disciplines';


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
        'delivered_date',
        'justification_date',
        'repeat',
        'repeat_number',
        'solution',
        'solution_date',
        'aggravating',
        'mitigating',
        'decision',
        'dacision_days',
        'first',
        'grau',
        'bi_date',
        'bi_text',
        'bi_number',
        'supplement_number',
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

            $transaction->first = 0;

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

    public function getNoteAttribute(): string
    {
        $aluno = $this->al_name ? "{$this->al_name} ({$this->al_nick})" : $this->al_nick;
        $faltas = is_array($this->json_faults) && count($this->json_faults) > 0
            ? 'Falta disciplinar nº ' . $this->formatList($this->json_faults)
            : '';

        $agravantes = is_array($this->json_aggravating) && count($this->json_aggravating) > 0
            ? 'com agravante(s) do nr ' . $this->formatList($this->json_aggravating)
            : 'sem agravantes';

        $atenuantes = is_array($this->json_mitigating) && count($this->json_mitigating) > 0
            ? 'com atenuante(s) do nr ' . $this->formatList($this->json_mitigating)
            : 'sem atenuante';

        $reincidencia = $this->repeat == 0
            ? 'não sendo reincidente'
            : 'sendo reincidente ' . ($this->repeat == 1 ? $this->repeat_number . " vez" . ($this->repeat_number > 1 ? 'es' : '') . " em faltas desta natureza" : '');

        $medida = '';
        if ($this->dacision_days) {
            $medida .= "{$this->dacision_days} dia" . ($this->dacision_days > 1 ? 's' : '') . ' de ';
        }

        if ($this->decision) {
            $penalidade = Penalty::fromDb($this->decision)?->label() ?? 'Advertência';
            $medida .= "$penalidade (FAFD nº {$this->number}/{$this->year} - {$this->cia})";
        }

        $grau = $this->students?->calculateAdjustedGrau(Carbon::parse($this->bi_date));

        return "Em {$this->f_date}, Al Nr {$this->al_number}, {$aluno}, turma {$this->al_class} - " .
            "Motivo: {$this->solution} {$faltas}, {$agravantes}, {$atenuantes}, previstos no apêndice 1 do anexo F do RICM 2024, " .
            "{$reincidencia} - Medida disciplinar: {$medida}, de {$this->f_date}) - Grau de comportamento {$grau}.";
    }

    private function formatList(array $itens): string
    {
        $total = count($itens);
        return collect($itens)->map(function ($item, $index) use ($total) {
            if ($index === $total - 2) {
                return "{$item} e";
            } elseif ($index === $total - 1) {
                return $item;
            }
            return "{$item},";
        })->implode(' ');
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
    public function getJsonAggravatingAttribute()
    {
        return json_decode($this->aggravating);
    }
    public function setAggravatingAttribute($value)
    {
        $this->attributes['aggravating'] = json_encode($value);
    }
    public function getJsonMitigatingAttribute()
    {
        return json_decode($this->mitigating);
    }
    public function setMitigatingAttribute($value)
    {
        $this->attributes['mitigating'] = json_encode($value);
    }

    //dates ('bi_date', 'solution_date','fact_date','sincomil_date')
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
    public function setSolutionDateAttribute($value)
    {
        $this->attributes['solution_date'] = $this->dbDate($value);
    }
    public function getSDateAttribute()
    {
        return $this->viewDate($this->solution_date);
    }
    public function setFactDateAttribute($value)
    {
        $this->attributes['fact_date'] = $this->dbDate($value);
    }
    public function getFDateAttribute()
    {
        return $this->viewDate($this->fact_date);
    }
    public function setDeliveredDateAttribute($value)
    {
        $this->attributes['delivered_date'] = $this->dbDate($value);
    }
    public function getDelivDateAttribute()
    {
        return $this->viewDate($this->delivered_date);
    }
    public function setJustificationDateAttribute($value)
    {
        $this->attributes['justification_date'] = $this->dbDate($value);
    }
    public function getjustDateAttribute()
    {
        return $this->viewDate($this->justification_date);
    }

    public function getTotalGrauAttribute()
    {
        if ($this->decision == 'retirada_cm') {
            return floatval($this->grau) * $this->dacision_days;
        } else {
            return floatval($this->grau);
        }
    }


    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id');
    }
    // public function oldStudents(): BelongsTo
    // {
    //     return $this->belongsTo(Peoples::class, 'student_id', 'id');
    // }
    public function observers(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'fact_observer_id', 'id')->where('active', 1);
    }
    public function fault(): BelongsTo
    {
        return $this->belongsTo(Faults::class, 'fault_id', 'id')->where('active', 1);
    }
    public function reincident($number, $date, $student_id)
    {
        $year = now()->year;
        $year = SchoolClassesYears::where("active", 1)->first()->year;

        $reincident = $this->where('student_id', $student_id)
            // ->where('faults', 'LIKE', '%' . $number . '%')
            ->whereJsonContains('faults', (int) $number)

            ->whereYear('fact_date', $year)
            ->where('fact_date', '<', $date)
            ->where('active', 1)
            ->where('decision', '!=', 'justificado')
            ->get()->count();
        return $reincident;
    }
}
