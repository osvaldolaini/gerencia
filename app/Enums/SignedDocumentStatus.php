<?php

namespace App\Enums;

enum SignedDocumentStatus: string
{
    case Current = 'current';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    /**
     * Valor utilizado no banco.
     */
    public function dbName(): string
    {
        return $this->value;
    }

    /**
     * Texto amigável.
     */
    public function label(): string
    {
        return match ($this) {
            self::Current   => 'Em assinatura',
            self::Completed => 'Documento concluído',
            self::Cancelled => 'Documento cancelado',
        };
    }

    /**
     * Cor para badges.
     */
    public function color(): string
    {
        return match ($this) {
            self::Current   => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'error',
        };
    }

    /**
     * Cria o enum a partir do valor do banco.
     */
    public static function fromDb(?string $dbValue): ?self
    {
        return $dbValue ? self::tryFrom($dbValue) : null;
    }

    /**
     * Documento em processo de assinatura.
     */
    public function isCurrent(): bool
    {
        return $this === self::Current;
    }

    /**
     * Documento finalizado.
     */
    public function isCompleted(): bool
    {
        return $this === self::Completed;
    }

    /**
     * Documento cancelado.
     */
    public function isCancelled(): bool
    {
        return $this === self::Cancelled;
    }
}
