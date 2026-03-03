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
use App\Models\Settings\ClassroomSeats;
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
    protected $actived = '';

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
        'mom',
        'dad',
        'city_birth',
        'state_birth',
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
                'dad',
                'mom',
                'state_birth',
                'city_birth',
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

            if ($transaction->active == 0) {
                $studentClasses = SchoolClassesStudent::where('active', 1)
                    ->where('people_id', $transaction->id)->get();
                if ($studentClasses) {
                    foreach ($studentClasses as $class) {
                        $class->active = 0;
                        $class->save();
                    }
                }
                $seat = ClassroomSeats::where('people_id', $transaction->id)->first();
                if ($seat) {
                    $seat->delete();
                }
            }
        });
    }

    // public function getNumberAttribute()
    // {
    //     return str_pad($this->number, 5, '0', STR_PAD_LEFT);
    // }

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
            ->orderBy('created_at', 'desc')
            ->where('people_id', $this->id)->first();
        if ($studentClass) {
            return $studentClass->class->title . ' / ' . ($studentClass->class->AllClassYears->year ?? 'Não informado');
        } else {
            return false;
        }
    }
    public function getAlClassAttribute()
    {
        $studentClass = SchoolClassesStudent::where('active', 1)
            ->orderBy('created_at', 'desc')
            ->where('people_id', $this->id)->first();
        if ($studentClass) {
            if ($studentClass->class) {
                return $studentClass->class;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function getCompanyAttribute()
    {
        if ($this->active == 1) {
            return $this->al_class->classGrade->company ?? '';
        } else {
            return false;
        }
    }
    public function getPeopleGradeAttribute()
    {
        $studentClass = SchoolClassesStudent::where('active', 1)
            ->orderBy('created_at', 'desc')
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
        // return $this->faults->where('active', 1)->where('justified', '!=', 2)->sum('qtd');
        // $actived = now()->year;
        $this->actived = now()->year;
        if (SchoolClassesYears::where("active", 1)->first()) {
            $this->actived = SchoolClassesYears::where("active", 1)->first()->year;
        }
        return $this->faults
            ->where('active', 1)
            ->where('justified', '!=', 2)
            ->filter(function ($fault) {
                return \Carbon\Carbon::parse($fault->date)->year == $this->actived;
            })
            ->sum('qtd');
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
    public function getActiveFaultsAttribute()
    {
        $this->actived = now()->year;
        if (SchoolClassesYears::where("active", 1)->first()) {
            $this->actived = SchoolClassesYears::where("active", 1)->first()->year;
        }
        return $this->faults
            ->where('active', 1)
            ->where('justified', '!=', 2)
            ->filter(function ($fault) {
                return \Carbon\Carbon::parse($fault->date)->year == $this->actived;
            });
        // return $this->faults();
    }
    public function contacts(): HasMany
    {
        return $this->hasMany(StudentContacts::class, 'student_id', 'id');
    }
    public function emails(): HasMany
    {
        return $this->hasMany(Emails::class, 'student_id', 'id');
    }
    public function alertEmails(): HasMany
    {
        return $this->hasMany(Emails::class, 'student_id', 'id')->where('type', '!=', 'record')->where('created_at', 'LIKE', '%' . date('Y') . '%');
    }
    public function activities(): HasMany
    {
        return $this->hasMany(StudentActivities::class, 'student_id', 'id');
    }
    public function calculateAdjustedGrau(?Carbon $dataFinal = null)
    {
        $nota = floatval($this->grau);
        $dataFinal = $dataFinal ?? now();

        // Buscar punições e elogios até a dataFinal
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

        Log::debug("Nota inicial: {$nota}");
        Log::debug("Data matrícula: {$this->entry_date}");
        Log::debug("Data final para cálculo: {$dataFinal->format('Y-m-d')}");

        // Montar lista única de eventos (compliment/punition) para ordenar cronologicamente
        $events = [];

        foreach ($elogios as $e) {
            // Garantir que bi_date é um Carbon
            if ($e->bi_date) {
                $events[] = [
                    'type' => 'compliment',
                    'date' => Carbon::parse($e->bi_date),
                    'model' => $e,
                ];
            }
        }

        foreach ($punicoes as $p) {
            if ($p->bi_date) {
                $events[] = [
                    'type' => 'punition',
                    'date' => Carbon::parse($p->bi_date),
                    'model' => $p,
                ];
            }
        }

        // ordenar por date asc; se mesmas datas, colocar compliments antes de punições
        usort($events, function ($a, $b) {
            if ($a['date']->eq($b['date'])) {
                // compliments first
                if ($a['type'] === $b['type']) return 0;
                return ($a['type'] === 'compliment') ? -1 : 1;
            }
            return $a['date']->lt($b['date']) ? -1 : 1;
        });

        // Se existirem punições, precisamos do primeiro para cálculo entre entry+90 e 1ª punição
        $dataReferencia = null;
        if ($punicoes->isEmpty()) {
            // Sem punições: aplicar acréscimo desde entry+90 até dataFinal (se aplicável)
            if ($this->entry_date) {
                $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);
                if ($dataFinal->gt($dataEntradaMais90)) {
                    $dias = $dataEntradaMais90->diffInDays($dataFinal);
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Sem punições. Dias após 90 da matrícula até {$dataFinal->format('Y-m-d')}: {$dias}. Aumento: {$incremento}. Nota: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
            }
            // Agora, mesmo sem punições, aplicar elogios que estejam na lista de eventos (eles já estão em $events)
        } else {
            // Há punições: aplicar acréscimo entre entry+90 e 1ª punição (mesmo se houver elogios nesse intervalo)
            if ($this->entry_date) {
                $primeiraPuni = Carbon::parse($punicoes->first()->bi_date);
                $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);

                if ($primeiraPuni->gt($dataEntradaMais90)) {
                    $dias = $dataEntradaMais90->diffInDays($primeiraPuni);
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota: {$nota}");
                } else {
                    Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
                }
            }
        }

        // Iterar todos os eventos em ordem cronológica e aplicar efeito no momento do evento
        foreach ($events as $ev) {
            if ($ev['type'] === 'compliment') {
                $e = $ev['model'];
                $grauElogio = floatval($e->grau);
                $nota += $grauElogio;
                $nota = min($nota, 10.00);
                Log::debug("Elogio em {$ev['date']->format('Y-m-d')}: +{$grauElogio}. Nota atual: {$nota}");
                // elogios NÃO alteram dataReferencia
            } else { // punition
                $p = $ev['model'];
                $dataP = $ev['date'];
                $grauPunicao = floatval($p->grau);

                if (!empty($p->dacision_days) && $p->dacision_days > 0) {
                    // regra que você tinha: para decision 'retirada_cm' multiplicar por dias; caso contrário apenas subtrair
                    if (isset($p->decision) && $p->decision === 'retirada_cm') {
                        $nota -= $grauPunicao * $p->dacision_days;
                    } else {
                        $nota -= $grauPunicao;
                    }
                } else {
                    $nota -= $grauPunicao;
                }

                $nota = max($nota, 0.00);
                Log::debug("Punição em {$dataP->format('Y-m-d')}: -{$grauPunicao}. Nota atual: {$nota}");

                // punição redefine dataReferencia (90 dias a partir da data da punição)
                $dataReferencia = $dataP->copy()->addDays(90);
                Log::debug("Nova data de referência após punição (90 dias): {$dataReferencia->format('Y-m-d')}");
            }
        }

        // Pós-última punição: aplicar acréscimo desde dataReferencia até dataFinal (se aplicável)
        if ($dataReferencia && $dataFinal->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays($dataFinal);
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);
            Log::debug("Ajuste final após 90 dias da última punição (até {$dataFinal->format('Y-m-d')}): +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            if ($dataReferencia) {
                Log::debug("Ainda não passaram 90 dias desde a última punição (referência: {$dataReferencia->format('Y-m-d')}).");
            }
        }

        return number_format($nota, 2);
    }
    // public function calculateAdjustedGrau(?Carbon $dataFinal = null)
    // {
    //     $nota = floatval($this->grau);
    //     $dataFinal = $dataFinal ?? now();
    //     $punicoes = $this->fafd()
    //         ->whereNotNull('bi_date')
    //         ->where('bi_date', '<=', $dataFinal)
    //         ->orderBy('bi_date')
    //         ->get();

    //     $elogios = $this->compliments()
    //         ->whereNotNull('bi_date')
    //         ->where('bi_date', '<=', $dataFinal)
    //         ->orderBy('bi_date')
    //         ->get();

    //     $dataReferencia = null;
    //     Log::debug("Nota inicial: {$nota}");
    //     Log::debug("Data matrícula: {$this->entry_date}");

    //     if ($punicoes->isEmpty()) {
    //         if ($this->entry_date) {
    //             $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
    //             if ($dataFinal->gt($dataReferencia)) {
    //                 $dias = $dataReferencia->diffInDays($dataFinal);
    //                 $incremento = $dias * 0.01;
    //                 $nota += $incremento;
    //                 $nota = min($nota, 10.00);
    //                 Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
    //             } else {
    //                 Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
    //             }
    //             // 🔥 Adiciona elogios (independente de punição)
    //             foreach ($elogios as $e) {
    //                 $grauElogio = floatval($e->grau);
    //                 $nota += $grauElogio;
    //                 $nota = min($nota, 10.00);
    //                 Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
    //             }
    //         }
    //         return number_format($nota, 2);
    //     }

    //     // Antes da primeira punição: incremento se aplicável
    //     $primeiraPunição = Carbon::parse($punicoes->first()->bi_date);
    //     $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);
    //     Log::debug("Data 1ª punição: {$primeiraPunição}");
    //     Log::debug("90 dias após matrícula: {$dataEntradaMais90}");

    //     if ($this->entry_date && $primeiraPunição->gt($dataEntradaMais90)) {
    //         $dias = $dataEntradaMais90->diffInDays($primeiraPunição);
    //         $incremento = $dias * 0.01;
    //         $nota += $incremento;
    //         $nota = min($nota, 10.00);
    //         Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota atual: {$nota}");
    //     } else {
    //         Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
    //     }

    //     // Aplica punições
    //     foreach ($punicoes as $p) {
    //         $dataP = Carbon::parse($p->bi_date);
    //         $grauPunicao = floatval($p->grau);

    //         if ($p->dacision_days > 0) {
    //             if ($p->decision == 'retirada_cm') {
    //                 $nota -= $grauPunicao * $p->dacision_days;
    //             } else {
    //                 $nota -= $grauPunicao;
    //             }
    //         } else {
    //             $nota -= $grauPunicao;
    //         }

    //         $nota = max($nota, 0.00);
    //         Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

    //         $dataReferencia = $dataP->copy()->addDays(90);
    //         Log::debug("Nova data de referência após punição (90 dias): {$dataReferencia->format('Y-m-d')}");
    //     }

    //     // Ajuste final se já passaram 90 dias da última punição
    //     if ($dataReferencia && $dataFinal->gt($dataReferencia)) {
    //         $dias = $dataReferencia->diffInDays($dataFinal);
    //         $incremento = $dias * 0.01;
    //         $nota += $incremento;
    //         $nota = min($nota, 10.00);
    //         Log::debug("Ajuste final após 90 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
    //     } else {
    //         Log::debug("Ainda não passaram 90 dias desde a última punição.");
    //     }
    //     // 🔥 Adiciona elogios (independente de punição)
    //     foreach ($elogios as $e) {
    //         $grauElogio = floatval($e->grau);
    //         $nota += $grauElogio;
    //         $nota = min($nota, 10.00);
    //         Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
    //     }

    //     return number_format($nota, 2, ',');
    // }
}
