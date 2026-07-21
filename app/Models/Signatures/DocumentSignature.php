<?php

namespace App\Models\Signatures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Enums\SignatureRole;

class DocumentSignature extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'document_signatures';

    protected $fillable = [
        'document_signed_id',
        'document_signer_id',
        'role',
        'ip',
        'signed_at',
    ];

    protected $casts = [
        'role' => SignatureRole::class,
        'signed_at' => 'datetime',
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

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentSigned::class, 'signed_document_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(DocumentSigner::class, 'document_signer_id');
    }
}
