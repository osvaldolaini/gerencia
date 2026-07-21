<?php

namespace App\Models\Signatures;

use App\Models\User;
use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Enums\SignatureRole;


class DocumentSigner extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'document_signers';

    protected $fillable = [
        'active',
        'user_id',
        'role',
        'certificate_path',
        'signature_password',
        'certificate_password',

        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $casts = [
        'role' => SignatureRole::class,

        'signature_password' => 'encrypted',
        'certificate_password' => 'encrypted',
    ];
    protected static function boot()
    {
        parent::boot();


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
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('active', 1);
    }
}
