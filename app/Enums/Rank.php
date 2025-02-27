<?php

namespace App\Enums;

enum Rank: string
{
    case Cabo = 'cabo';
    case TerceiroSargento = 'terceiro_sargento';
    case SegundoSargento = 'segundo_sargento';
    case PrimeiroSargento = 'primeiro_sargento';
    case Subtenente = 'subtenente';
    case Aspirante = 'aspirante';
    case SegundoTenente = 'segundo_tenente';
    case PrimeiroTenente = 'primeiro_tenente';
    case Capitao = 'capitao';
    case Major = 'major';
    case TenenteCoronel = 'tenente_coronel';
    case Coronel = 'coronel';

    public function dbName(): string
    {
        return match ($this) {
            self::Cabo => 'cabo',
            self::TerceiroSargento => 'terceiro_sargento',
            self::SegundoSargento => 'segundo_sargento',
            self::PrimeiroSargento => 'primeiro_sargento',
            self::Subtenente => 'subtenente',
            self::Aspirante => 'aspirante',
            self::SegundoTenente => 'segundo_tenente',
            self::PrimeiroTenente => 'primeiro_tenente',
            self::Capitao => 'capitao',
            self::Major => 'major',
            self::TenenteCoronel => 'tenente_coronel',
            self::Coronel => 'coronel',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Cabo => 'Cabo',
            self::TerceiroSargento => '3º Sargento',
            self::SegundoSargento => '2º Sargento',
            self::PrimeiroSargento => '1º Sargento',
            self::Subtenente => 'Subtenente',
            self::Aspirante => 'Aspirante',
            self::SegundoTenente => '2º Tenente',
            self::PrimeiroTenente => '1º Tenente',
            self::Capitao => 'Capitão',
            self::Major => 'Major',
            self::TenenteCoronel => 'Tenente-Coronel',
            self::Coronel => 'Coronel',
        };
    }
}
