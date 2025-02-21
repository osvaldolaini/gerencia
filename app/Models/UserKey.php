<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class UserKey extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'private_key_path',
        'public_key_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }
}
