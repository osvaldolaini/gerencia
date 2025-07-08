<?php

namespace App\Models;

use App\Models\Discipline\Compliments;
use App\Models\Discipline\FactObserved;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Extracurricular\StudentActivities;
use App\Models\Fault\SchoolFaults;
use App\Models\Settings\SchoolBattalionStudents;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Students\StudentContacts;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use App\Traits\HasAdjustedGrau;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Peoples extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions, HasAdjustedGrau;

    protected $table = 'peoples';

    protected $fillable = [
        'active',
        'name',
        'nick',
        'sex',
        'number',
        'logo_path',
        'birthday',
        'type',
        'user_id',
        'posto_grad',
        'function',
        'grau',
        'entry_date',
        'english_level',
        'code',
        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];
    protected $casts = [
        'grau' => 'float',  // Força o grau a ser interpretado como número
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
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $this->dbDate($value);
    }
    public function getBirthAttribute()
    {
        if ($this->birthday != "") {
            return $this->viewDate($this->birthday);
        }
    }
    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $this->dbDate($value);
    }
    public function getEntryAttribute()
    {
        if ($this->entry_date != "") {
            return $this->viewDate($this->entry_date);
        }
    }

    public function setGrauAttribute($value)
    {
        $this->attributes['grau'] = $this->dbValue($value);
    }
    public function getGrauViewAttribute()
    {
        if ($this->grau != "") {
            return $this->viewValue($this->grau);
        }
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
    public function getCompanyAttribute()
    {
        if ($this->active == 1) {
            return $this->al_class->classGrade->company;
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
    public function getTotalFaultsAttribute()
    {
        return $this->faults->where('active', 1)->where('justified', '!=', 2)->sum('qtd');
    }
    public function getTotalFaultsPercentAttribute()
    {
        return ($this->total_faults ?? 0) / ($this?->company?->workload ?? 1200) * 100;
    }
    public function getTotalFaultsColorAttribute()
    {
        $nota = $this->total_faults_percent;
        if ($nota >= 25) {
            return 'error';
        } elseif ($nota >= 7.5) {
            return 'error';
        } elseif ($nota >= 6.0) {
            return 'warning';
        } else {
            return 'accent';
        }
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
    public function getRankAttribute()
    {
        return SchoolBattalionStudents::where('people_id', $this->id)->where('active', 1)->first();
    }

    public function fo(): HasMany
    {
        return $this->hasMany(FactObserved::class, 'student_id', 'id');
    }
    public function fafd(): HasMany
    {
        return $this->hasMany(FaultDiscipline::class, 'student_id', 'id');
    }
    public function compliments(): HasMany
    {
        return $this->hasMany(Compliments::class, 'student_id', 'id');
    }
    public function faults(): HasMany
    {
        return $this->hasMany(SchoolFaults::class, 'student_id', 'id');
    }
    public function contacts(): HasMany
    {
        return $this->hasMany(StudentContacts::class, 'student_id', 'id')->where("active", 1);
    }
    public function emails(): HasMany
    {
        return $this->hasMany(Emails::class, 'student_id', 'id');
    }
    public function activities(): HasMany
    {
        return $this->hasMany(StudentActivities::class, 'student_id', 'id');
    }
    public function calculateAdjustedGrau(?Carbon $dataFinal = null)
    {
        $nota = floatval($this->grau);
        $dataFinal = $dataFinal ?? now();
        $punicoes = $this->fafd()
            ->whereNotNull('bi_date')
            ->where('bi_date', '<=', $dataFinal)
            ->orderBy('bi_date')
            ->get();

        $elogios = $this->compliments()
            ->whereNotNull('bi_date')
            ->where('bi_date', '<=', $dataFinal)
            ->orderBy('bi_date')
            ->get();

        $dataReferencia = null;
        Log::debug("Nota inicial: {$nota}");
        Log::debug("Data matrícula: {$this->entry_date}");

        if ($punicoes->isEmpty()) {
            if ($this->entry_date) {
                $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
                if ($dataFinal->gt($dataReferencia)) {
                    $dias = $dataReferencia->diffInDays($dataFinal);
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
                // 🔥 Adiciona elogios (independente de punição)
                foreach ($elogios as $e) {
                    $grauElogio = floatval($e->grau);
                    $nota += $grauElogio;
                    $nota = min($nota, 10.00);
                    Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
                }
            }
            return number_format($nota, 2);
        }

        // Antes da primeira punição: incremento se aplicável
        $primeiraPunição = Carbon::parse($punicoes->first()->bi_date);
        $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);
        Log::debug("Data 1ª punição: {$primeiraPunição}");
        Log::debug("90 dias após matrícula: {$dataEntradaMais90}");

        if ($this->entry_date && $primeiraPunição->gt($dataEntradaMais90)) {
            $dias = $dataEntradaMais90->diffInDays($primeiraPunição);
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);
            Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota atual: {$nota}");
        } else {
            Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
        }

        // Aplica punições
        foreach ($punicoes as $p) {
            $dataP = Carbon::parse($p->bi_date);
            $grauPunicao = floatval($p->grau);

            if ($p->dacision_days > 0) {
                $nota -= $grauPunicao * $p->dacision_days;
            } else {
                $nota -= $grauPunicao;
            }

            $nota = max($nota, 0.00);
            Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

            $dataReferencia = $dataP->copy()->addDays(90);
            Log::debug("Nova data de referência após punição (90 dias): {$dataReferencia->format('Y-m-d')}");
        }

        // Ajuste final se já passaram 90 dias da última punição
        if ($dataReferencia && $dataFinal->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays($dataFinal);
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);
            Log::debug("Ajuste final após 90 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            Log::debug("Ainda não passaram 90 dias desde a última punição.");
        }
        // 🔥 Adiciona elogios (independente de punição)
        foreach ($elogios as $e) {
            $grauElogio = floatval($e->grau);
            $nota += $grauElogio;
            $nota = min($nota, 10.00);
            Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
        }

        return number_format($nota, 2, ',');
    }
}
