<div>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-4">
        @livewire('discipline.panel.discipline-panel-card')
        <span class="col-span-full sm:col-span-2">
            <div
                class="relative h-32 overflow-hidden text-gray-100 bg-gray-800 rounded-lg shadow-md dark:text-gray-800 dark:bg-gray-100">
                <div class="p-4 ">
                    <dl>
                        <dt class="flex justify-between text-sm font-medium leading-5 truncate">
                            Mapa de faltas disciplinares
                            <button wire:click='generatePdf()'
                                class="py-1 text-gray-900 transition-colors duration-200 btn btn-outline btn-success whitespace-nowrap">
                                Gerar
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                    viewBox="0 0 512 512" xml:space="preserve">

                                    <g>
                                        <path d="M347.746,346.204c-8.398-0.505-28.589,0.691-48.81,4.533c-11.697-11.839-21.826-26.753-29.34-39.053
                                            c24.078-69.232,8.829-88.91-11.697-88.91c-16.119,0-24.167,17.011-22.376,35.805c0.906,9.461,8.918,29.34,18.78,48.223
                                            c-6.05,15.912-16.847,42.806-27.564,62.269c-12.545,3.812-23.305,8.048-31.027,11.622c-38.465,17.888-41.556,41.773-33.552,51.894
                                            c15.197,19.226,47.576,2.638,80.066-55.468c22.243-6.325,51.508-14.752,54.146-14.752c0.304,0,0.721,0.097,1.204,0.253
                                            c16.215,14.298,35.366,30.67,51.128,32.825c22.808,3.136,35.791-13.406,34.891-23.692
                                            C382.703,361.461,376.691,347.942,347.746,346.204z M203.761,408.88c-9.401,11.178-24.606,21.9-29.972,18.334
                                            c-5.373-3.574-6.265-13.86,5.819-25.497c12.076-11.623,32.29-17.657,35.329-18.787c3.59-1.337,4.482,0,4.482,1.791
                                            C219.419,386.512,213.154,397.689,203.761,408.88z M244.923,258.571c-0.899-11.192,1.33-21.922,10.731-23.26
                                            c9.386-1.352,13.868,9.386,10.292,26.828c-3.582,17.464-5.38,29.08-7.164,30.44c-1.79,1.338-3.567-3.144-3.567-3.144
                                            C251.627,282.27,245.815,269.748,244.923,258.571z M248.505,363.697c4.912-8.064,17.442-40.702,17.442-40.702
                                            c2.683,4.926,23.699,29.956,23.699,29.956S257.438,360.123,248.505,363.697z M345.999,377.995
                                            c-13.414-1.768-36.221-17.895-36.221-17.895c-3.128-1.337,24.992-5.157,35.79-4.466c13.875,0.9,18.794,6.718,18.794,12.53
                                            C364.362,373.982,359.443,379.787,345.999,377.995z" />
                                        <path class="st0" d="M461.336,107.66l-98.34-98.348L353.683,0H340.5H139.946C92.593,0,54.069,38.532,54.069,85.901v6.57H41.353
                                            v102.733h12.716v230.904c0,47.361,38.525,85.893,85.878,85.893h244.808c47.368,0,85.893-38.532,85.893-85.893V130.155v-13.176
                                            L461.336,107.66z M384.754,480.193H139.946c-29.875,0-54.086-24.212-54.086-54.086V195.203h157.31V92.47H85.86v-6.57
                                            c0-29.882,24.211-54.102,54.086-54.102H332.89v60.894c0,24.888,20.191,45.065,45.079,45.065h60.886v288.349
                                            C438.855,455.982,414.636,480.193,384.754,480.193z M88.09,166.086v-47.554c0-0.839,0.683-1.524,1.524-1.524h15.108
                                            c2.49,0,4.786,0.409,6.837,1.212c2.029,0.795,3.812,1.91,5.299,3.322c1.501,1.419,2.653,3.144,3.433,5.121
                                            c0.78,1.939,1.182,4.058,1.182,6.294c0,2.282-0.402,4.414-1.19,6.332c-0.78,1.918-1.932,3.619-3.418,5.054
                                            c-1.479,1.427-3.27,2.549-5.321,3.329c-2.036,0.78-4.332,1.174-6.822,1.174h-6.376v17.241c0,0.84-0.683,1.523-1.523,1.523h-7.208
                                            C88.773,167.61,88.09,166.926,88.09,166.086z M134.685,166.086v-47.554c0-0.839,0.684-1.524,1.524-1.524h16.698
                                            c3.173,0,5.968,0.528,8.324,1.568c2.386,1.062,4.518,2.75,6.347,5.009c0.944,1.189,1.694,2.504,2.236,3.916
                                            c0.528,1.375,0.929,2.862,1.189,4.407c0.253,1.531,0.401,3.181,0.453,4.957c0.045,1.694,0.067,3.515,0.067,5.447
                                            c0,1.924-0.022,3.746-0.067,5.44c-0.052,1.769-0.2,3.426-0.453,4.964c-0.26,1.546-0.661,3.025-1.189,4.399
                                            c-0.55,1.427-1.3,2.743-2.23,3.909c-1.842,2.282-3.976,3.969-6.354,5.016c-2.334,1.04-5.135,1.568-8.324,1.568h-16.698
                                            C135.368,167.61,134.685,166.926,134.685,166.086z M214.269,137.981c0.84,0,1.523,0.684,1.523,1.524v6.48
                                            c0,0.84-0.683,1.524-1.523,1.524h-18.244v18.579c0,0.84-0.684,1.523-1.524,1.523h-7.209c-0.84,0-1.523-0.683-1.523-1.523v-47.554
                                            c0-0.839,0.683-1.524,1.523-1.524h27.653c0.839,0,1.524,0.684,1.524,1.524v6.48c0,0.84-0.684,1.524-1.524,1.524h-18.92v11.444
                                            H214.269z" />
                                        <path class="st0"
                                            d="M109.418,137.706c1.212-1.092,1.798-2.645,1.798-4.749c0-2.096-0.587-3.649-1.798-4.741
                                            c-1.263-1.13-2.928-1.68-5.098-1.68h-5.975v12.848h5.975C106.489,139.385,108.155,138.836,109.418,137.706z" />
                                        <path class="st0" d="M156.139,157.481c1.13-0.424,2.103-1.107,2.973-2.088c0.944-1.055,1.538-2.571,1.769-4.511
                                            c0.26-2.208,0.386-5.091,0.386-8.569c0-3.485-0.126-6.369-0.386-8.569c-0.231-1.946-0.825-3.462-1.762-4.51
                                            c-0.869-0.982-1.873-1.679-2.972-2.089c-1.182-0.453-2.534-0.676-4.042-0.676h-7.164v31.68h7.164
                                            C153.605,158.15,154.965,157.927,156.139,157.481z" />
                                    </g>
                                </svg>
                            </button>
                        </dt>
                        <dd class="font-bold text-md">
                            <form>
                                <div class="grid w-full grid-cols-2 space-x-2">
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-900 ">Data
                                            Inicial</label>
                                        <input type="date" wire:model.live="date_start"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-900">Data
                                            Final</label>
                                        <input type="date" wire:model.live="date_end"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>

                                </div>
                            </form>
                        </dd>
                    </dl>
                </div>
            </div>
        </span>
    </div>
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">

        <div>
            @livewire('discipline.charts.fault-disciplines-by-grade')
        </div>
        <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
            <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor"
                    viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M338.824 57.966v222.155H0v1581.29h225.882V506.117h112.942v222.268l406.814-335.21L338.824 57.967Zm1355.407 448.15h225.882V280.122H1694.23v225.996Zm-338.937 0h225.995V280.122h-225.995v225.996Zm-338.823 0h225.882V280.122H1016.47v225.996ZM677.76 957.882h1242.353V732H677.76v225.882Zm0 451.765h1242.353v-225.995H677.76v225.995Zm0 451.765h1242.353v-225.883H677.76v225.883Z"
                        fill-rule="evenodd" />
                </svg>
                Alunos com mais FAFD
            </h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($topStudentsFafd as $fact)
                    @if ($fact->students)
                        <li class="py-3">
                            <div class="flex items-center justify-between">
                                @if ($fact->students)
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">
                                            <span class="shadow-md badge badge-neutral">
                                                {{ $fact->students?->al_class?->title ?? 'Sem turma'}}
                                            </span>
                                            {{ $fact->students->name }}
                                        </p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $fact->students->nick }}
                                        </p>
                                    </div>
                                @endif
                                <span class="inline-block px-3 py-1 text-sm text-red-800 bg-red-100 rounded-full">
                                    {{ $fact->total }}
                                </span>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
            <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                FAFD recentes
            </h2>
            <!-- Lançamentos Recentes -->
            <ul class="divide-y divide-gray-200">
                @foreach ($recentFafd as $fault)
                    <li class="py-3">
                        <div class="flex items-center justify-between">
                            @if ($fault->students)
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100">
                                        <span class="shadow-md badge badge-neutral">

                                            {{ $fault->students->al_class->title }}

                                        </span>
                                        {{ $fault->students->name }}
                                    </p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $fault->f_date }}
                                    </p>
                                </div>
                            @endif
                            <span class="inline-block px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                                {{ $fault->fact_observer }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    {{-- MODAL READ --}}

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Mapa de falta disciplinare do {{ $config->nick }} no período
            de
            {{ Carbon::createFromFormat('Y-m-d', $date_start)->format('d/m/Y') }}
            a
            {{ Carbon::createFromFormat('Y-m-d', $date_end)->format('d/m/Y') }}</x-slot>
        <x-slot name="content">
            <div class="text-sm">
                <table class="border"
                    style="border-collapse: collapse; width: 100%; font-family: sans-serif; font-size: 8px;">
                    <thead>
                        <tr>
                            <th class="border" rowspan="2" colspan="2"
                                style=" width: 20%; text-align: center; py-20 ">
                                Medidas disciplinares<br>e comportamentos<br><br>
                                Anos escolares
                            </th>
                            <th class="border" colspan="6" style=" text-align: center;">
                                Distribuição das medidas disciplinares
                            </th>
                            <th class="border" colspan="6" style=" text-align: center;">
                                Efetivo de Alunos por comportamento
                            </th>
                        </tr>
                        <tr>
                            {{-- Cabeçalhos das punições --}}
                            <th class="py-10 origin-left transform rotate-90 border ">Advertência
                            </th>
                            <th class="origin-left transform rotate-90 border ">Repreensão</th>
                            <th class="origin-left transform rotate-90 border ">AOE</th>
                            <th class="origin-left transform rotate-90 border ">Retirada</th>
                            <th class="origin-left transform rotate-90 border ">Exclusão</th>
                            <th class="origin-left transform rotate-90 border ">TOTAL</th>

                            {{-- Cabeçalhos do comportamento --}}
                            <th class="origin-left transform rotate-90 border ">Excepcional
                            </th>
                            <th class="origin-left transform rotate-90 border ">Ótimo</th>
                            <th class="origin-left transform rotate-90 border ">Bom</th>
                            <th class="origin-left transform rotate-90 border ">Regular</th>
                            <th class="origin-left transform rotate-90 border ">Insuficiente
                            </th>
                            <th class="origin-left transform rotate-90 border ">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_array($tabela))
                            @foreach ($tabela as $serie => $valores)
                                <tr>
                                    <td class="border" style="text-align:center;">
                                        @switch($serie)
                                            @case('6º ANO')
                                                Ensino Fundamental
                                            @break

                                            @case('7º ANO')
                                                Ensino Fundamental
                                            @break

                                            @case('8º ANO')
                                                Ensino Fundamental
                                            @break

                                            @case('9º ANO')
                                                Ensino Fundamental
                                            @break

                                            @case('1º ANO')
                                                Ensino Médio
                                            @break

                                            @case('2º ANO')
                                                Ensino Médio
                                            @break

                                            @case('3º ANO')
                                                Ensino Médio
                                            @break

                                            Ensino Fundamental

                                            @default
                                        @endswitch
                                    </td>
                                    <td class="border " style=" text-align:center;">{{ $serie }}
                                    </td>

                                    {{-- Medidas disciplinares --}}
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['advertencia'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['repreensao'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['atividade_orientacao_educacional'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['retirada_cm'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['exclusao_disciplinar'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        <strong>{{ $valores['TOTAL'] ?? 0 }}</strong>
                                    </td>

                                    {{-- Comportamentos (exemplo zerado; substitua pelos reais se tiver) --}}
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['excepcional'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['otimo'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['bom'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['regular'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        {{ $valores['insuficiente'] ?? 0 }}</td>
                                    <td class="border " style=" text-align:center;">
                                        <strong>{{ $valores['total_comportamento'] ?? 0 }}</strong>
                                    </td>
                                </tr>
                            @endforeach

                            </tr>

                        @endif
                    </tbody>
                </table>
            </div>

            <div id="modalContent" class="hidden bg-white border">
                <h1 class="text-sm">MAPA DE FALTAS DISCIPLINARES</h1>
                <div class=" box">
                    <table>
                        <tr>
                            <td style="text-align: left;" width="75%">
                                <table>
                                    <tr>
                                        <td>
                                            <span>MINISTÉRIO DA DEFESA</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>EXÉRCITO BRASILEIRO</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>{{ $config->nick }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <th style="text-align: right;">
                                <table>
                                    <tr>
                                        <td style="text-align: left;">
                                            <span>QIE – 10</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">
                                            <span>
                                                Assunto:
                                            </span> estatística do ensino
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">
                                            <span>Referência:</span> NRRD
                                        </td>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                    <div class="bt" style="padding-top: 5px;padding-bottom:5px;text-align:center;">
                        <span>
                            MAPA DISCIPLINAR DO CORPO DE ALUNOS DO {{ $config->nick }} NO PERÍODO DE
                            {{ Carbon::createFromFormat('Y-m-d', $date_start)->format('d/m/Y') }}
                            A
                            {{ Carbon::createFromFormat('Y-m-d', $date_end)->format('d/m/Y') }}
                        </span>
                    </div>

                    <table style="border-collapse: collapse; width: 100%; font-family: sans-serif; font-size: 12px;">
                        <thead>
                            <tr>
                                <th rowspan="2" colspan="2"
                                    style="border: 1px solid #000; width: 20%; text-align: center;">
                                    Medidas disciplinares<br>e comportamentos<br><br>
                                    Anos escolares
                                </th>
                                <th colspan="6" style="border: 1px solid #000; text-align: center;">
                                    Distribuição das medidas disciplinares
                                </th>
                                <th colspan="6" style="border: 1px solid #000; text-align: center;">
                                    Efetivo de Alunos por comportamento
                                </th>
                            </tr>
                            <tr>
                                {{-- Cabeçalhos das punições --}}
                                <th style="border: 1px solid #000;" class="vertical-text">Advertência</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Repreensão</th>
                                <th style="border: 1px solid #000;" class="vertical-text">AOE</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Retirada</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Exclusão</th>
                                <th style="border: 1px solid #000;" class="vertical-text">TOTAL</th>

                                {{-- Cabeçalhos do comportamento --}}
                                <th style="border: 1px solid #000;" class="vertical-text">Excepcional</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Ótimo</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Bom</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Regular</th>
                                <th style="border: 1px solid #000;" class="vertical-text">Insuficiente</th>
                                <th style="border: 1px solid #000;" class="vertical-text">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (is_array($tabela))
                                @foreach ($tabela as $serie => $valores)
                                    <tr>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            @switch($serie)
                                                @case('6º ANO')
                                                    Ensino Fundamental
                                                @break

                                                @case('7º ANO')
                                                    Ensino Fundamental
                                                @break

                                                @case('8º ANO')
                                                    Ensino Fundamental
                                                @break

                                                @case('9º ANO')
                                                    Ensino Fundamental
                                                @break

                                                @case('1º ANO')
                                                    Ensino Médio
                                                @break

                                                @case('2º ANO')
                                                    Ensino Médio
                                                @break

                                                @case('3º ANO')
                                                    Ensino Médio
                                                @break

                                                Ensino Fundamental

                                                @default
                                            @endswitch
                                        </td>
                                        <td style="border: 1px solid #000; text-align:center;">{{ $serie }}
                                        </td>

                                        {{-- Medidas disciplinares --}}
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['advertencia'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['repreensao'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['atividade_orientacao_educacional'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['retirada_cm'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['exclusao_disciplinar'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            <strong>{{ $valores['TOTAL'] ?? 0 }}</strong>
                                        </td>

                                        {{-- Comportamentos (exemplo zerado; substitua pelos reais se tiver) --}}
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['excepcional'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['otimo'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['bom'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['regular'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            {{ $valores['insuficiente'] ?? 0 }}</td>
                                        <td style="border: 1px solid #000; text-align:center;">
                                            <strong>{{ $valores['total_comportamento'] ?? 0 }}</strong>
                                        </td>
                                    </tr>
                                @endforeach

                                </tr>

                            @endif
                        </tbody>
                    </table>

                    <table style="margin-left:20px;margin-right:20px;margin-bottom:30px;">
                        <tr>
                            <td class="t-left" width="50%">
                                <table width="100%">
                                    <tr>
                                        <td style="padding-top:40px;">
                                            <p>______________________________________</p>
                                            <p style="text-align: center">Guarnição / Data</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:40px;">
                                            <p>______________________________________</p>
                                            <p style="text-align: center">Cmt CA</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                                &nbsp;
                            </td>
                            <td class="t-left" width="50%">
                                <table>
                                    <tr>
                                        <td style="padding-top:40px;">
                                            <p>&nbsp;</p>
                                            <p style="text-align: left;">Visto:</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:40px;">
                                            <p>______________________________________</p>
                                            <p style="text-align: center">Cmt CM</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>

                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-secondary-button onclick="printModalContent()">Imprimir relatório
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    @section('scripts')
        <script>
            function printModalContent() {
                const content = document.getElementById('modalContent').innerHTML;
                const printWindow = window.open('', '', 'width=900,height=650');
                printWindow.document.write('<html><head><title>Imprimir Relatório</title>');
                printWindow.document.write(
                    '<style>body{font-family:sans-serif;font-size:12px;}.box{border:1.5px solid black;}.bt{border-top:1px solid black;}table{border-collapse:collapse;}h1{text-align:center;font-size:12pt;}.assinaturas{margin-top:40px;font-size:10pt;}.assinaturas p{margin:6px 0;}span{font-weight:bold;}.t-left{text-align:left;}.t-right{text-align:right;}.vertical-text{writing-mode:vertical-rl;text-align:center;transform: rotate(180deg);padding;10px; }</style>'
                );
                printWindow.document.write('</head><body>');
                printWindow.document.write(content);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }
        </script>
    @endsection



</div>
