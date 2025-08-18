<?php

namespace App\Models\Discipline;

use App\Enums\ComplimentType;
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

class Compliments extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'compliments';

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
        'fact_observer',
        'fact_observer_function',
        'fact_observer_id',
        'solution',
        'solution_date',
        'compliment_type',
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


        $medida = '';
        if ($this->dacision_days) {
            $medida .= "{$this->dacision_days} dia" . ($this->dacision_days > 1 ? 's' : '') . ' de ';
        }

        if ($this->decision) {
            $penalidade = ComplimentType::fromDb($this->decision)?->label() ?? 'Advertência';
            $medida .= "$penalidade (FAFD nº {$this->number}/{$this->year} - {$this->cia})";
        }

        $grau = $this->students?->calculateAdjustedGrau(Carbon::parse($this->bi_date));

        return "{$this->solution}" .
            " - Grau de comportamento {$grau}.";

            // return "Em {$this->f_date}, Al Nr {$this->al_number}, {$aluno}, turma {$this->al_class} - " .
            // "{$this->solution}" .
            // " - Grau de comportamento {$grau}.";

        // $this->sugestion = 'Em ' . $this->f_date . ', Al Nr ' . $this->al_number . ', ' . $this->students->name . ', turma ' . $this->al_class . ' - ';
        // $this->sugestion .= $this->fact;
        // $this->sugestion .= ' (FO positivo nº ' . $this->fo->number . '/' . $this->fo->year . ').';
        // $this->sugestion .= ' Medida disciplinar: Elogio ' . ComplimentType::from($this->compliment_type)->label() . '.';
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

    public function getTotalGrauAttribute()
    {

        return floatval($this->grau);
    }
    public function getFactNumberAttribute()
    {
        return $this->number . '/' . $this->year;
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

    public function students(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'student_id', 'id')->where('active', 1);
    }

    public function observers(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'fact_observer_id', 'id')->where('active', 1);
    }
    public function getFoAttribute()
    {
        return FactObserved::where('compliment_id', $this->id)->first();
    }
}
