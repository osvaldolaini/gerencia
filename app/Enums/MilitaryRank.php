<?php

namespace App\Enums;

enum MilitaryRank: int
{
    // Praças
    case Civil = 0;
    case Soldado = 1;
    case Marinheiro = 2;
    case Cabo = 4;
    case TerceiroSargento = 7;
    case SegundoSargento = 10;
    case PrimeiroSargento = 13;
    case Subtenente = 16;
    case Suboficial = 17;

        // Oficiais Subalternos
    case Aspirante = 19;
    case GuardaMarinha = 20;
    case SegundoTenente = 22;
    case PrimeiroTenente = 25;

        // Oficiais Intermediários
    case Capitao = 28;
    case CapitaoTenente = 29;

        // Oficiais Superiores
    case Major = 31;
    case CapitaoCorveta = 32;
    case TenenteCoronel = 34;
    case CapitaoFragata = 35;
    case Coronel = 37;
    case CapitaoMarEGuerra = 38;

    /**
     * Retorna o nome do banco de dados.
     */
    public function dbName(): int
    {
        return $this->value;
    }

    /**
     * Retorna o nome formatado da patente.
     */
    public function label(): string
    {
        return match ($this) {
            self::Civil => 'Civil',
            self::Soldado => 'Soldado',
            self::Marinheiro => 'Marinheiro',
            self::Cabo => 'Cabo',
            self::TerceiroSargento => '3º Sargento',
            self::SegundoSargento => '2º Sargento',
            self::PrimeiroSargento => '1º Sargento',
            self::Subtenente => 'Subtenente',
            self::Suboficial => 'Suboficial',
            self::Aspirante => 'Aspirante a Oficial',
            self::GuardaMarinha => 'Guarda-Marinha',
            self::SegundoTenente => '2º Tenente',
            self::PrimeiroTenente => '1º Tenente',
            self::Capitao => 'Capitão',
            self::CapitaoTenente => 'Capitão-Tenente',
            self::Major => 'Major',
            self::CapitaoCorveta => 'Capitão de Corveta',
            self::TenenteCoronel => 'Tenente-Coronel',
            self::CapitaoFragata => 'Capitão de Fragata',
            self::Coronel => 'Coronel',
            self::CapitaoMarEGuerra => 'Capitão de Mar e Guerra',
        };
    }

    public function nick(): string
    {
        return match ($this) {
            self::Civil => 'Cv',
            self::Soldado => 'Sd',
            self::Marinheiro => 'Mn',
            self::Cabo => 'Cb',
            self::TerceiroSargento => '3º Sgt',
            self::SegundoSargento => '2º Sgt',
            self::PrimeiroSargento => '1º Sgt',
            self::Subtenente => 'ST',
            self::Suboficial => 'SO',
            self::Aspirante => 'Asp Of',
            self::GuardaMarinha => 'GM',
            self::SegundoTenente => '2º Ten',
            self::PrimeiroTenente => '1º Ten',
            self::Capitao => 'Cap',
            self::CapitaoTenente => 'CT',
            self::Major => 'Maj',
            self::CapitaoCorveta => 'CC',
            self::TenenteCoronel => 'TC',
            self::CapitaoFragata => 'CF',
            self::Coronel => 'Cel',
            self::CapitaoMarEGuerra => 'CMG',
        };
    }
    /**
     * Retorna a instância do enum a partir do valor do banco de dados.
     */
    public static function fromDb(int $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
