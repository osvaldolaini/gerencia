<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolBattalions extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'school_battalions';

    protected $fillable = [
        'active',
        'year',
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
            if ($model->active) {
                // Define todos os outros registros como inativos
                static::where('id', '!=', $model->id)->update(['active' => false]);

                // Desativar todos os registros da tabela pivot
                SchoolBattalionStudents::query()->update(['active' => false]);

                // Ativar apenas os registros da pivot relacionados à grade ativa
                SchoolBattalionStudents::where('school_battalions_id', $model->id)->update(['active' => true]);
            }
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

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClasses::class, 'school_classes_year_id', 'id');
    }
    public function ranks(): HasMany
    {
        return $this->hasMany(SchoolBattalionStudents::class, 'school_battalions_id', 'id');
    }
}
