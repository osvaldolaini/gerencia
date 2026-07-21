<?php

namespace App\Enums;

enum DocumentType: string
{
    /*
    |--------------------------------------------------------------------------
    | Documentos Escolares
    |--------------------------------------------------------------------------
    */

    case SecondCallAuthorization = 'second_call_authorization';
    case StudentEnrollment = 'student_enrollment';
    case StudentCard = 'student_card';


        /*
    |--------------------------------------------------------------------------
    | Outros
    |--------------------------------------------------------------------------
    */

    case Other = 'other';

    /**
     * Nome amigável.
     */
    public function label(): string
    {
        return match ($this) {
            self::SecondCallAuthorization => 'Autorização de segunda chamada',
            self::StudentEnrollment => 'Certidão de matrícula',
            self::StudentCard => 'Carteirinha estudantil',
        };
    }


    /**
     * Ícone (opcional para futuras telas).
     */
    public function icon(): string
    {
        return match ($this) {
            self::SecondCallAuthorization => 'heroicon-o-exclamation-circle',
            self::StudentEnrollment => 'heroicon-o-exclamation-circle',
            self::StudentCard =>  'heroicon-o-exclamation-circle',
        };
    }

    /**
     * Cor padrão para badges.
     */
    public function color(): string
    {
        return match ($this) {
            self::SecondCallAuthorization => 'warning',
            self::StudentEnrollment => 'success',
            self::StudentCard =>  'success',
        };
    }
}
