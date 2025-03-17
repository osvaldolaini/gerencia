<?php

namespace App\Enums;

enum Penalty: string
{
    case Advertencia = 'advertencia';
    case Repreensao = 'repreensao';
    case AOE = 'atividade_orientacao_educacional';
    case RetiradaCM = 'retirada_cm';
    case ExclusaoDisciplinar = 'exclusao_disciplinar';

    public function label(): string
    {
        return match ($this) {
            self::Advertencia => 'Advertência',
            self::Repreensao => 'Repreensão',
            self::AOE => 'Atividade de Orientação Educacional (AOE)',
            self::RetiradaCM => 'Retirada do CM',
            self::ExclusaoDisciplinar => 'Exclusão Disciplinar',
        };
    }

    public function degree(): int
    {
        return match ($this) {
            self::Advertencia => 0.0,
            self::Repreensao => 0.3,
            self::AOE => 0.5,
            self::RetiradaCM => 0.8,
            self::ExclusaoDisciplinar => 0.0,
        };
    }
}
