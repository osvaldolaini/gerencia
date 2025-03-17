<?php

namespace App\Enums;

enum Elogio: string
{
    case ElogioColetivoBI = 'elogio_coletivo_bi';
    case ElogioIndividualBI = 'elogio_individual_bi';
    case ElogioColetivoDEPA = 'elogio_coletivo_diretor';
    case ElogioIndividualDEPA = 'elogio_individual_diretor';

    public function label(): string
    {
        return match ($this) {
            self::ElogioColetivoBI => 'Elogio coletivo em BI/CM',
            self::ElogioIndividualBI => 'Elogio individual em BI/CM',
            self::ElogioColetivoDEPA => 'Elogio coletivo do Diretor da DEPA',
            self::ElogioIndividualDEPA => 'Elogio individual do Diretor da DEPA',
        };
    }

    public function degree(): int
    {
        return match ($this) {
            self::ElogioColetivoBI => 0.1,
            self::ElogioIndividualBI => 0.3,
            self::ElogioColetivoDEPA => 0.3,
            self::ElogioIndividualDEPA => 0.5,
        };
    }
}
