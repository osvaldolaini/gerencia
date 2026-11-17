<?php

namespace App\Enums;

enum PollQuestionType: string
{
    case SINGLE_CHOICE = 'single_choice';
    case MULTIPLE_CHOICE = 'multiple_choice';
    case TEXT = 'text';

    public function label(): string
    {
        return match ($this) {
            self::SINGLE_CHOICE => 'Escolha única',
            self::MULTIPLE_CHOICE => 'Múltipla escolha',
            self::TEXT => 'Resposta aberta',
        };
    }

    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
