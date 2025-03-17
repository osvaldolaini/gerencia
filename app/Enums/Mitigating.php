<?php

namespace App\Enums;

enum Mitigating: int
{
    case MenosTresMeses = 1;
    case CriancaOuAdolescente = 2;
    case ComportamentoBom = 3;
    case PrimeiraFalta = 4;
    case FaltaDePratica = 5;
    case RelevanciaAcoes = 6;
    case EvitarMalMaior = 7;
    case DefesaPropria = 8;

    public function label(): string
    {
        return match ($this) {
            self::MenosTresMeses => 'Ser aluno matriculado com menos de 03 (três) meses',
            self::CriancaOuAdolescente => 'Ser por sua idade considerado criança ou adolescente',
            self::ComportamentoBom => 'Estar no comportamento BOM, ÓTIMO ou EXCEPCIONAL',
            self::PrimeiraFalta => 'Ser a primeira falta',
            self::FaltaDePratica => 'Falta de prática nas atividades típicas do discente',
            self::RelevanciaAcoes => 'A relevância de ações prestadas',
            self::EvitarMalMaior => 'Ter sido cometida a falta para evitar mal maior',
            self::DefesaPropria => 'Ter sido cometida a falta em defesa própria de seus direitos ou de outrem, não se configurando causa de justificação',
        };
    }
}
