<?php

namespace App\Enums;

enum SchoolFault: int
{
    case NãoJustificada = 0;
    case Justificada = 1;
    case Abonada = 2;

    public function label(): string
    {
        return match ($this) {
            self::NãoJustificada => 'Não justificada',
            self::Justificada => 'Justificada',
            self::Abonada => 'Abonada',
        };
    }

    public function degree(): float
    {
        return match ($this) {
            self::NãoJustificada => 3,
            self::Justificada => 1,
            self::Abonada => 0,
        };
    }
    public function text(): string
    {
        return match ($this) {
            self::NãoJustificada => 'Não',
            self::Justificada => 'Sim',
            self::Abonada => 'Abonada',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::NãoJustificada => 'badge-error',
            self::Justificada => 'badge-info',
            self::Abonada => 'badge-success',
        };
    }

    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
