<p align="center"><a href="https://github.com/osvaldolaini" target="_blank"><img src="https://avatars.githubusercontent.com/u/75580327?v=4" width="100" alt="Laravel Logo"></a></p>

## Versão Santos Dumont 1.3.7

> Correções

    ->PDF (Justificativa, solução e nota)
    ->Criar FAFD
    ->Dados apresntados no resumo do fato
    ->Gravar data FO SINCOMIL

    <div class="flex items-center justify-center col-span-1 mt-5 dark:text-gray-900">
                            <div
                                class="w-56 mr-4 bg-white shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box card card-compact">

                                <div class="mx-auto mt-5" wire:click="goCourse('{{ $grade->id }}')">
                                    {{-- <x-application-logo width="h-12"></x-application-logo> --}}
                                    {{ $grade->name }}
                                </div>
                                <div class="card-body">
                                    <div class="w-full mt-auto">
                                        <div class="flex justify-center font-medium duration-200">
                                            {{-- Opções visíveis em telas grandes --}}
                                            <div class="space-x-1 md:flex">
                                                <div class="p-0 tooltip tooltip-top" data-tip="Montar">
                                                    <a href="{{ route('school-battalion-students-mount', [$school_battalions->id, $grade->id]) }}"
                                                        class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

## Versão Santos Dumont 1.3.6

> Novidades

    ->Botão para ver o fato

> Correções

    ->Ordem dos alunos por nome (chamada)
    ->Logo na chamada
    ->Busca dos aluno no Batalhão
    ->Gravar data FO SINCOMIL

## Versão Santos Dumont 1.3.5 - Painel

> Novidades

    ->Quantidade de alunos por turma no painel
    ->Gráfico de (M/F) por turma

## Versão Santos Dumont 1.3.4 - Faltas (user)

> Novidades

    ->Lançamento de faltas
    ->Inserir Pdf

## Versão Santos Dumont 1.3.3 - Faltas (admin)

> Novidades

    ->Lançamento de faltas
    ->Inserir Pdf

> Correções

    ->Upload da foto do aluno
    ->Tabela da turma com tamanho da folha
    ->Usuário trocar o nome
    ->Correção do redirecionamenteo de "app" para "aplicativo"

## Versão Santos Dumont 1.3.2 - APP

> Novidades

    ->Painel para mobile

## Versão Santos Dumont 1.3.1 - APP

> Novidades

    ->Editar perfil do usuário

> Melhorias

    ->Baixar planilha modelo para importar alunos em lote
    ->importar alunos em lote

## Versão Santos Dumont 1.3.0 - APP

> Novidades

    ->Página do usuário

## Versão Santos Dumont 1.2.0 - disciplina

> Novidades

    ->Lançamento de FO

> Melhorias

    ->Criar FAFD a partir do FO

## Versão Santos Dumont 1.1.0 - disciplina

> Novidades

    ->Processo de FAFD
    ->Cadastro de faltas disciplinares
    ->Selects (atenuante, agravante, observadores, punições)

## Versão Santos Dumont 1.0.0

> Melhorias

    ->Cadastro do efetivo
    ->imagem do aluno na lista
    ->Novos campos cadastro alunos (sexo, grau de comportamento)
    ->Novo campo cadastro colégio (sigla)
    ->inclusão do nome do CMT da cia no cadastro da CIA

> Correções

    ->Somente um batalhao ativo
    ->Somente um ano escolar ativo
    ->Só aparecem os alunos do ano para compor o batalhão

## Versão Santos Dumont (beta)

> Novo
> Configurações

    ->Cadastro de escola
    ->Cadastro de companhias
    ->Cadastro de batalhão
    ->Cadastro de séries
    ->Cadastro de turmas
    ->Inclusão e exclusão de alunos na turma
    ->Inclusão e exclusão de alunos no batalhão

> Cadastros

    ->Cadastro de alunos (nome,sexo,nome de guerra,número)
    ->Usuários
