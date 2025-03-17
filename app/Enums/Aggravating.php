<?php

namespace App\Enums;

enum Aggravating: int
{
    case OficialOuGraduado = 1;
    case AlunoCFR = 2;
    case ComportamentoRuim = 3;
    case FaltaEmAtividadeEscolar = 4;
    case Reincidencia = 5;
    case MultiplasFaltas = 6;
    case Conluio = 7;
    case AbusoDeAtribuicao = 8;
    case FaltaEmPublico = 9;
    case Premeditacao = 10;

    public function label(): string
    {
        return match ($this) {
            self::OficialOuGraduado => 'Ser oficial-aluno ou graduado',
            self::AlunoCFR => 'Ser aluno do CFR, quando ativado, ou já o haver concluído',
            self::ComportamentoRuim => 'Estar no comportamento REGULAR, INSUFICIENTE ou MAU',
            self::FaltaEmAtividadeEscolar => 'Cometer a falta em atividade escolar, hora de aula ou instrução',
            self::Reincidencia => 'Reincidência, no mesmo tipo de falta disciplinar',
            self::MultiplasFaltas => 'Prática simultânea ou conexão de 02 (duas) ou mais faltas disciplinares',
            self::Conluio => 'Conluio de 02 (dois) ou mais alunos',
            self::AbusoDeAtribuicao => 'Ter abusado o faltoso disciplinar de atribuição que lhe foi conferida para o exercício de atividade escolar',
            self::FaltaEmPublico => 'Ter cometido a falta em público, na presença de tropa ou de aluno em forma ou em sala de aula',
            self::Premeditacao => 'Ter agido com premeditação, no cometimento da falta',
        };
    }
}
