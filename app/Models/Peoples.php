<?php

namespace App\Models;

use App\Models\Discipline\FactObserved;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Fault\SchoolFaults;
use App\Models\Settings\SchoolBattalionStudents;
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


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
    public function getBirthAttribute($value)
    {
        if ($value != "") {
            return $this->viewDate($value);
        }
    }
    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $this->dbDate($value);
    }
    public function getEntryAttribute($value)
    {
        if ($value != "") {
            return $this->viewDate($value);
        }
    }

    public function setGrauAttribute($value)
    {
        $this->attributes['grau'] = $this->dbValue($value);
    }
    public function getGrauAttribute($value)
    {
        if ($value != "") {
            return $this->viewValue($value);
        }
    }
    //FUNÇÃO PARA PEGAR O GRAU
    // public function getAdjustedGrauAttribute()
    // {
    //     $nota = floatval($this->grau);
    //     $punicoes = $this->fafd()->whereNotNull('bi_date')->orderBy('bi_date')->get();

    //     $dataReferencia = null;

    //     foreach ($punicoes as $p) {
    //         $dataP = Carbon::parse($p->bi_date);
    //         // Aplica punição
    //         $f = floatval($p->grau);
    //         $nota -= $f;  // Aplica a punição

    //         // Verifique o valor da nota após cada punição
    //         Log::debug("Nota após punição: {$nota}");

    //         if ($nota < 0) {
    //             $nota = 0.00;
    //         }

    //         // Reinicia contagem com a nova punição
    //         $dataReferencia = $dataP->copy()->addDays(90);

    //         if ($dataReferencia && now()->gt($dataReferencia)) {
    //             $dias = $dataReferencia->diffInDays(now());
    //             $nota += $dias * 0.01;

    //             // Garantir que a nota não ultrapasse 10.00
    //             if ($nota > 10) {
    //                 $nota = 10.00;
    //             }

    //             // Verifique o valor da nota após o aumento diário
    //             Log::debug("Nota após aumento diário: {$nota} (Dias: {$dias})");
    //         }

    //         Log::debug("Data referência para a próxima punição: {$dataReferencia}");
    //     }

    //     // Se já passou dos 90 dias da última punição, sobe 0,01 por dia até hoje
    //     if ($dataReferencia && now()->gt($dataReferencia)) {
    //         $dias = $dataReferencia->diffInDays(now());
    //         $nota += $dias * 0.01;
    //         if ($nota > 10) {
    //             $nota = 10.00;
    //         }
    //     }
    //     Log::debug("Nota após punição: {$nota}");
    //     // $nota = floatval($nota);

    //     return number_format(floatval($nota), 2);
    //     // return number_format(floatval($nota), 2);
    // }
    public function getAdjustedGrauAttribute()
    {
        // $nota = number_format(floatval($this->grau), 2);
        number_format($this->grau, 2, '.', '');
        $punicoes = $this->fafd()->whereNotNull('bi_date')->orderBy('bi_date')->get();
        $dataReferencia = null;
        Log::debug("Nota inicial sem float: {$this->grau}");
        Log::debug("Nota inicial: {$nota}");

        if ($punicoes->isEmpty()) {
            if ($this->entry_date) {
                $dias = Carbon::parse($this->entry_date)->diffInDays(now());
                $nota += $dias * 0.01;
                $nota = number_format(min($nota, 10.00), 2);
                Log::debug("Sem punições. Dias desde matrícula: {$dias}. Nota final: {$nota}");
            }
            return $nota;
        }

        foreach ($punicoes as $p) {
            $dataP = Carbon::parse($p->bi_date);
            $grauPunicao = number_format(floatval($p->grau), 2);

            $nota -= $grauPunicao;
            $nota = number_format(max($nota, 0.00), 2);

            Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

            $dataReferencia = $dataP->copy()->addDays(90);
            Log::debug("Nova data de referência após punição: {$dataReferencia->format('Y-m-d')}");

            if (now()->gt($dataReferencia)) {
                $dias = $dataReferencia->diffInDays(now());
                $incremento = number_format($dias * 0.01, 2);
                $nota += $incremento;
                $nota = number_format(min($nota, 10.00), 2);

                Log::debug("Passaram-se {$dias} dias após 90 dias. Aumento de {$incremento}. Nota atual: {$nota}");
            }
        }

        // Considerar novamente o aumento final após a última punição
        if ($dataReferencia && now()->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays(now());
            $incremento = number_format($dias * 0.01, 2);
            $nota += $incremento;
            $nota = number_format(min($nota, 10.00), 2);

            Log::debug("Ajuste final após última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
        }

        return $nota;
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
    public function faults(): HasMany
    {
        return $this->hasMany(SchoolFaults::class, 'student_id', 'id');
    }
}
