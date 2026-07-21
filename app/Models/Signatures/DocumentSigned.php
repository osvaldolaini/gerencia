<?php

namespace App\Models\Signatures;

use App\Enums\SignatureRole;
use App\Enums\SignedDocumentStatus;
use App\Enums\DocumentType;
use App\Models\Signatures\DocumentSignature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Support\Facades\Storage;

//Gravar a HASH
use Illuminate\Support\Facades\Hash;


class DocumentSigned extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'document_signed';

    protected $fillable = [
        'uuid',
        'document_type',
        'document_model',
        'document_id',
        'file_path',
        'hash',
        'created_by',
        'status',
        'revocation_reason',
        'replaced_by',
        'signed_at',
        'revoked_at',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'revoked_at' => 'datetime',
        'status' => SignedDocumentStatus::class,
        'document_type' => DocumentType::class,
    ];


    protected static function boot()
    {
        parent::boot();


        static::creating(function ($transaction) {
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


    public function generateHash(): string
    {
        $payload = [
            'uuid' => $this->uuid,
            'type' => $this->document_type,
            'model' => $this->document_model,
            'document_id' => $this->document_id,
            'signed_at' => optional($this->signed_at)->toISOString(),

            'signatures' => $this->signatures
                ->sortBy('signed_at')
                ->map(fn($signature) => [
                    'signer' => $signature->document_signer_id,
                    'role' => $signature->role->value,
                    'signed_at' => optional($signature->signed_at)->toISOString(),
                ])
                ->values()
                ->all(),
        ];

        return hash(
            'sha256',
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );
    }

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(DocumentSignature::class, 'document_signed_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function replacedBy(): BelongsTo
    {
        return $this->belongsTo(self::class, 'replaced_by');
    }

    /**
     * Documento que foi substituído por este.
     */
    public function replaces(): HasOne
    {
        return $this->hasOne(self::class, 'replaced_by');
    }

    public function isCurrent(): bool
    {
        return $this->status === 'current';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Verifica se todas as assinaturas obrigatórias foram realizadas.
     */
    public function isFullySigned(): bool
    {
        $model = app($this->document_model)->find($this->document_id);

        if (!$model || !method_exists($model, 'requiredSignatures')) {
            return false;
        }

        /*
    |--------------------------------------------------------------------------
    | Assinaturas obrigatórias do documento
    |--------------------------------------------------------------------------
    */
        $requiredRoles = collect($model->requiredSignatures())
            ->map(fn(SignatureRole $role) => $role->value);

        /*
    |--------------------------------------------------------------------------
    | Assinaturas já realizadas
    |--------------------------------------------------------------------------
    */
        $signedRoles = $this->signatures
            ->pluck('role')
            ->map(fn($role) => $role instanceof SignatureRole ? $role->value : $role);

        /*
    |--------------------------------------------------------------------------
    | Todas as roles obrigatórias estão presentes?
    |--------------------------------------------------------------------------
    */
        return $requiredRoles
            ->diff($signedRoles)
            ->isEmpty();
    }

    /**
     * Verifica a integridade do PDF oficial comparando
     * o hash SHA-256 armazenado no banco de dados com
     * o hash calculado a partir do arquivo atualmente
     * armazenado no disco.
     *
     * @return bool True se o documento estiver íntegro;
     *              False caso o arquivo não exista,
     *              não tenha sido gerado ou tenha sido
     *              alterado.
     */
    public function isValid(): bool
    {
        if (!$this->file_path) {
            return false;
        }

        if (!Storage::disk('public')->exists($this->file_path)) {
            return false;
        }

        return hash_equals(
            $this->hash,
            hash_file(
                'sha256',
                Storage::disk('public')->path($this->file_path)
            )
        );
    }
}
