<?php

namespace App\Enums;

enum Penalty: string
{
    case Justificado = 'justificado';
    case Fo = 'fo';
    case Advertencia = 'advertencia';
    case Repreensao = 'repreensao';
    case AOE = 'atividade_orientacao_educacional';
    case RetiradaCM = 'retirada_cm';
    case ExclusaoDisciplinar = 'exclusao_disciplinar';

    public static function permitidos(): array
    {
        $formasPermitidas = [
            'fo',
            'advertencia',
            'repreensao',
            'atividade_orientacao_educacional',
            'retirada_cm',
            'exclusao_disciplinar',
        ];

        // Filtra o enum com base nas formas permitidas
        return array_filter(self::cases(), fn($forma) => in_array($forma->value, $formasPermitidas));
    }

    public function label(): string
    {
        return match ($this) {
            self::Justificado => 'Justificado',

            self::Fo => 'FO',
            self::Advertencia => 'Advertência',
            self::Repreensao => 'Repreensão',
            self::AOE => 'Atividade de Orientação Educacional (AOE)',
            self::RetiradaCM => 'Retirada do CM',
            self::ExclusaoDisciplinar => 'Exclusão Disciplinar',
        };
    }

    public function degree(): float
    {
        return match ($this) {
            self::Justificado => 0.0,

            self::Fo => 0.0,
            self::Advertencia => 0.0,
            self::Repreensao => 0.3,
            self::AOE => 0.5,
            self::RetiradaCM => 0.8,
            self::ExclusaoDisciplinar => 0.0,
        };
    }

    public function days(): int
    {
        return match ($this) {
            self::Justificado => 0,

            self::Fo => 0,
            self::Advertencia => 0,
            self::Repreensao => 0,
            self::AOE => 1,
            self::RetiradaCM => 1,
            self::ExclusaoDisciplinar => 0,
        };
    }
    public function sugestion($days): string
    {
        return match ($this) {
            self::Justificado => 'Justificado',

            self::Fo                    => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido registrar um FO',
            self::Advertencia           => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido punir o(a) aluno(a) com uma advertência publicada em BI',
            self::Repreensao            => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido punir o(a) aluno(a) com repreenção publicada em BI',
            self::AOE                   => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido punir o(a) aluno(a) com ' . $days . ' dia' . ($days > 1 ? 's' : '') . ' de Atividade de Orientação Educacional (AOE)',
            self::RetiradaCM            => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido punir o(a) aluno(a) com ' . $days . ' dia' . ($days > 1 ? 's' : '') . ' de retirada',
            self::ExclusaoDisciplinar   => 'Por fim, no uso de minhas atribuições de Comandante de Companhia decido excluir o(a) aluno(a) do ...',
        };
    }
    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
