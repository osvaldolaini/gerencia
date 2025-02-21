<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'name',
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
}
