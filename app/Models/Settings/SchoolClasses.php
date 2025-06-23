<?php

namespace App\Models\Settings;

use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolClasses extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_classes';

    protected $fillable = [
        'active',
        'title',
        'school_classes_year_id',
        'school_grade_id',
        'order',
        'rows',
        'columns',
        'door_side',
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



            // Obtém todos os números das turmas ativas do mesmo ano, ordenados
            $existingNumbers = self::where('school_classes_year_id', $transaction->school_classes_year_id)
                ->where('active', 1)
                ->orderBy('title')
                ->pluck('title')
                ->toArray();

            // Calcula o prefixo baseado no ano escolar (exemplo: 8º ano → 800)
            $prefix = intval($transaction->classGrade->nick);

            // Encontra o menor número disponível na sequência
            $newNumber = self::findNextAvailableNumber($existingNumbers, $prefix);

            // Atribui o número à nova turma
            $transaction->title = $newNumber;
        });

        static::updating(function ($transaction) {
            $transaction->updated_by = Auth::user()->name;
        });
    }
    private static function findNextAvailableNumber($existingNumbers, $prefix)
    {
        if (empty($existingNumbers)) {
            return $prefix + 1; // Se não houver turmas, começa com o primeiro número do prefixo (ex: 801)
        }

        // Percorre a sequência para encontrar a menor lacuna disponível
        for ($i = $prefix + 1; $i <= max($existingNumbers) + 1; $i++) {
            if (!in_array($i, $existingNumbers)) {
                return $i;
            }
        }

        return max($existingNumbers) + 1; // Caso não encontre lacuna, segue a sequência
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


    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = $value;
        if ($value == 0) {
            $this->order = 99999;
            $this->save();
        } else {
            if ($this->school_classes_year_id) {
                $last = $this->where('school_classes_year_id', $this->school_classes_year_id)->orderBy('order', 'desc')
                    ->first();
                $this->order = $last->order + 1;
                $this->save();
            }
        }
    }

    public function classYears(): BelongsTo
    {
        return $this->belongsTo(SchoolClassesYears::class, 'school_classes_year_id', 'id')->where('active', 1);
    }
    public function classGrade(): BelongsTo
    {
        return $this->belongsTo(SchoolGrades::class, 'school_grade_id', 'id')->where('active', 1);
    }
    public function studentsPivot(): HasMany
    {
        return $this->hasMany(SchoolClassesStudent::class, 'school_classes_id', 'id')->where('active', 1);
    }
    public function seats(): HasMany
    {
        return $this->hasMany(ClassroomSeats::class, 'school_classes_id', 'id');
    }
}
