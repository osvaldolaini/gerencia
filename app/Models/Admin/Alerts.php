<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Traits\HasAttributeConversions;

class Alerts extends Model
{
    use HasFactory, LogsActivity;
    use HasAttributeConversions;

    protected $table = 'alerts';

    protected $fillable = [
        'active',
        'title',
        'description',
        'link',
        'deadline',
        'updated_by',
        'created_by',
        'updated_because',
        'deleted_at',
        'deleted_because',
        'deleted_by'
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'title',
                'description',
                'updated_by',
                'created_by',
                'updated_because',
                'deleted_because',
                'deleted_by'
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
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = mb_strtoupper($value);
    }

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = $this->dbDate($value);
    }
    public function getDeadlineAttribute($value)
    {
        if ($value != "") {
            return $this->viewDate($value);
        }
    }
    public function scopeFilterFields($query, $filters)
    {

        foreach ($filters as $key => $value) {
            $converted = $value;
            // Exemplo de conversão para o campo 'typeAircraft'
            if ($key == 'convertDate') {
                if (substr_count($value, " ") === 1) {
                    $partesSpace = explode(" ", $value);
                    if (substr_count($partesSpace[0], "/") === 1) {
                        $partes = explode("/", $partesSpace[0]);
                        $converted = $partes[1] . "%-" . $partes[0] . "% " . $partesSpace[1];
                    } elseif (substr_count($partesSpace[0], "/") === 2) {
                        $partes = explode("/", $partesSpace[0]);
                        $converted = $partes[2] . "%-" . $partes[1] . "-" . $partes[0] . "% " . $partesSpace[1];
                    } else {
                        $converted = $value;
                    }
                } else {
                    if (substr_count($value, "/") === 1) {
                        $partes = explode("/", $value);
                        $converted = $partes[1] . "%-" . $partes[0];
                    } elseif (substr_count($value, "/") === 2) {
                        $partes = explode("/", $value);
                        $converted = $partes[2] . "%-" . $partes[1] . "-" . $partes[0];
                    } else {
                        $converted = $value;
                    }
                }
                return array('f' => 'LIKE', 'converted' => '%' . $converted . '%');
            } else {
                return false;
            }
            // Adicione mais campos personalizados conforme necessário
        }
    }
    public function users()
    {
        return $this->hasMany(AlertsUser::class, 'alert_id', 'id');
    }
}
