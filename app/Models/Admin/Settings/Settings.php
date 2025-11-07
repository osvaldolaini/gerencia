<?php

namespace App\Models\Admin\Settings;

use App\Models\Peoples;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'name',
        'nick',
        'slug',
        'cpf_cnpj',
        'postalCode',
        'number',
        'address',
        'district',
        'city',
        'state',
        'complement',
        'board',
        'logo_path',
        'signature_id',
        'updated_by',
    ];

    public function setAddress()
    {
        $address = $this->address;
        if ($this->city) {
            $address .= ' - ' . $this->city;
        }
        if ($this->state) {
            $address .= '/' . $this->state;
        }
        if ($this->postalCode) {
            $address .= ' - CEP ' . $this->postalCode;
        }
        return $address;
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function signature(): BelongsTo
    {
        return $this->belongsTo(Peoples::class, 'signature_id', 'id')->where('active', 1);
    }
}
