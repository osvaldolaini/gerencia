<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faults')->insert([
            ['id' => 1, 'active' => 1, 'title' => 'Faltar à verdade.', 'number' => 1],
            ['id' => 2, 'active' => 1, 'title' => 'Utilizar-se de livros, cadernos ou outros materiais pertencentes a colegas, sem o devido consentimento.', 'number' => 2],
            ['id' => 3, 'active' => 1, 'title' => 'Deixar de comparecer ou chegar atrasado às atividades programadas.', 'number' => 3],
            ['id' => 4, 'active' => 1, 'title' => 'Apresentar-se com uniforme diferente do que foi previamente estabelecido.', 'number' => 4],
            ['id' => 5, 'active' => 1, 'title' => 'Ter pouco cuidado com o asseio próprio ou coletivo e com sua apresentação individual.', 'number' => 5],
            ['id' => 6, 'active' => 1, 'title' => 'Trocar de uniforme em locais não apropriados.', 'number' => 6],
            ['id' => 7, 'active' => 1, 'title' => 'Deixar material ou dependência sob sua responsabilidade, desarrumada ou com má apresentação, ou para tal contribuir.', 'number' => 7],
            ['id' => 8, 'active' => 1, 'title' => 'Deixar de apresentar material, documento ou trabalhos escolares de sua responsabilidade, nas atividades escolares ou quando solicitado, em dia e em ordem.', 'number' => 8],
            ['id' => 9, 'active' => 1, 'title' => 'Deixar de cumprir o prescrito nos regulamentos, normas e orientações, ou contribuir para tal.', 'number' => 9],
            ['id' => 10, 'active' => 1, 'title' => 'Ocupar-se durante as aulas com qualquer outro trabalho estranho a elas.', 'number' => 10],
            ['id' => 11, 'active' => 1, 'title' => 'Ausentar-se das atividades escolares sem autorização.', 'number' => 11],
            ['id' => 12, 'active' => 1, 'title' => 'Representar o Colégio ou por ele tomar compromisso, sem estar para isso autorizado.', 'number' => 12],
            ['id' => 13, 'active' => 1, 'title' => 'Simular doença para esquivar-se ao atendimento de obrigações e atividades escolares.', 'number' => 13],
            ['id' => 14, 'active' => 1, 'title' => 'Causar danos materiais a outro aluno.', 'number' => 14],
            ['id' => 15, 'active' => 1, 'title' => 'Ter em seu poder, introduzir, ler ou distribuir, dentro do colégio, cartazes, jornais ou publicações, de cunho político-partidário ou que atentem contra a disciplina ou a moral.', 'number' => 15],
            ['id' => 16, 'active' => 1, 'title' => 'Propor ou aceitar transação pecuniária de qualquer natureza, no interior do colégio.', 'number' => 16],
            ['id' => 17, 'active' => 1, 'title' => 'Deixar de usar ou usar de maneira irregular, peças de uniforme previstas no RUE/CM ou nas normas vigentes.', 'number' => 17],
            ['id' => 18, 'active' => 1, 'title' => 'Deixar de devolver à subunidade, dentro do prazo estipulado, qualquer documento, devidamente assinado pelo pai ou responsável.', 'number' => 18],
            ['id' => 19, 'active' => 1, 'title' => 'Não levar falta ou irregularidade que presenciar, ou de que tiver ciência e não lhe couber reprimir, ao conhecimento de autoridade competente.', 'number' => 19],
            ['id' => 20, 'active' => 1, 'title' => 'Utilizar sem devida autorização telefones celulares e/ou aparelhos eletrônicos nas atividades escolares, nas instruções ou em formaturas, perturbando o desenvolvimento das atividades, sob pena de serem recolhidos e entregue somente aos responsáveis.', 'number' => 20]
        ]);
    }
}
