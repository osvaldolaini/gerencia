<div>
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">

        <div>
            @livewire('faults.charts.faults-by-week')
        </div>
        <!-- Alunos com Mais Faltas -->
        <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
            <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor"
                    viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M338.824 57.966v222.155H0v1581.29h225.882V506.117h112.942v222.268l406.814-335.21L338.824 57.967Zm1355.407 448.15h225.882V280.122H1694.23v225.996Zm-338.937 0h225.995V280.122h-225.995v225.996Zm-338.823 0h225.882V280.122H1016.47v225.996ZM677.76 957.882h1242.353V732H677.76v225.882Zm0 451.765h1242.353v-225.995H677.76v225.995Zm0 451.765h1242.353v-225.883H677.76v225.883Z"
                        fill-rule="evenodd" />
                </svg>
                Alunos com mais faltas
            </h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($topStudents as $student)
                    @if ($student?->students)
                        <li class="py-3">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-800 dark:text-gray-100">
                                    <span class="shadow-md badge badge-neutral">
                                        {{ $student?->students?->al_class->title ?? 'Sem turma' }}
                                    </span>
                                    {{ $student?->students->name }}
                                </p>
                                <span class="inline-block px-3 py-1 text-sm text-red-800 bg-red-100 rounded-full">
                                    {{ $student->total_faults }} {{ Str::plural('falta', $student->total_faults) }}
                                    ({{ number_format((($student->total_faults ?? 0) / ($fault->students->company->workload ?? 1200)) * 100, 2, ',', '') }}%)
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
                Lançamentos recentes
            </h2>
            <!-- Lançamentos Recentes -->
            <ul class="divide-y divide-gray-200">
                @foreach ($recentFaults as $fault)
                    <li class="py-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">
                                    <span class="shadow-md badge badge-neutral">
                                        {{-- {{ $fault->students->al_class->title }} --}}
                                        {{ $fault->students->al_class->title ?? 'Sem turma' }}
                                    </span>
                                    {{ $fault->students->name }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($fault->date)->format('d/m/Y') }}
                                </p>
                            </div>
                            <span class="inline-block px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                                {{ $fault->qtd }} {{ Str::plural('período', $fault->qtd) }}

                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            @livewire('faults.charts.faults-by-grade')
        </div>
    </div>

</div>
