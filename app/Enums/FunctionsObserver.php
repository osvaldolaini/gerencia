<?php

namespace App\Enums;


enum FunctionsObserver: string
{
    case Monitor = 'monitor';
    case Sargenteante = 'sargenteante';
    case CmtCia = 'cmt_cia';
    case CmtCa = 'cmt_ca';
    case CmtDe = 'cmt_de';
    case CmtCm = 'cmt_cm';
    case Professor = 'professor';
    case Outros = 'outros';

    public function dbName(): string
    {
        return match ($this) {
            self::Monitor => 'monitor',
            self::Sargenteante => 'sargenteante',
            self::CmtCia => 'cmt_cia',
            self::CmtCa => 'cmt_ca',
            self::CmtDe => 'cmt_de',
            self::CmtCm => 'cmt_cm',
            self::Professor => 'professor',
            self::Outros => 'outros',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Monitor => 'Monitor',
            self::Sargenteante => 'Sargenteante',
            self::CmtCia => 'Comandante da cia',
            self::CmtCa => 'Comandante do CA',
            self::CmtDe => 'Comandante da DE',
            self::CmtCm => 'Comandante do colégio',
            self::Professor => 'Professor',
            self::Outros => 'Outros',
        };
    }
    /**
     * Retorna a instância do enum a partir do valor do banco de dados.
     */
    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
