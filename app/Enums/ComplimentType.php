<?php

namespace App\Enums;

enum ComplimentType: string
{
    case Coletivo = 'coletivo_cm';
    case Individual = 'individual_cm';
    case Coletivo_DEPA = 'coletivo_depa';
    case Individual_DEPA = 'individual_depa';

    public function label(): string
    {
        return match ($this) {
            self::Coletivo          => 'Coletivo em BI/CM',
            self::Individual        => 'Individual em BI/CM',
            self::Coletivo_DEPA         => 'Coletivo do Diretor da DEPA',
            self::Individual_DEPA   => 'Individual do Diretor da DEPA',
        };
    }

    public function degree(): float
    {
        return match ($this) {
            self::Coletivo          => 0.1,
            self::Individual        => 0.3,
            self::Coletivo_DEPA          => 0.3,
            self::Individual_DEPA   => 0.5,
        };
    }
    public function signature($cm): string
    {
        return match ($this) {
            self::Coletivo          => 'Comandante do ' . $cm,
            self::Individual        => 'Comandante do ' . $cm,
            self::Coletivo_DEPA     => 'Diretor da DEPA ',
            self::Individual_DEPA   => 'Diretor da DEPA ',
        };
    }

    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
