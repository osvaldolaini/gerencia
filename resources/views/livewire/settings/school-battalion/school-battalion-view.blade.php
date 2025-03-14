<div>
    @php
        use App\Enums\Rank;
    @endphp

    @forelse ($companies->where('active',1)->sortByDesc('nick') as $company)

        @forelse ($company->grade->where('active',1)->sortByDesc('nick') as $grade)
            @if ($grade->battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad')->count() > 0)
                <small
                    class="flex justify-center w-full ml-2 space-x-1 text-5xl font-extrabold text-center text-gray-500 dark:text-gray-100">
                    {{ $grade->name }}
                </small>
            @endif

            <div
                class="grid grid-cols-{{ $grade->battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad')->count() }} gap-4">
                <!-- Define número de colunas -->
                @foreach ($grade->battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad') as $posto => $items)
                    <div class="p-4 ">
                        <!-- Exibir nome do posto -->
                        <h2 class="text-lg font-bold text-center">
                            {{ Rank::fromDb($posto)?->label() ?? 'Patente' }}
                        </h2>

                        <!-- Exibir ícone da patente -->
                        <div class="flex justify-center my-2">
                            <img src="{{ Rank::fromDb($posto)?->imageBg() ?? Storage::url('ranks/fundo/default.png') }}"
                                alt="Patente" class="w-12 h-12 rounded-full">
                        </div>

                        <!-- Listar os alunos dentro do posto -->
                        @foreach ($items as $item)
                            <div class="py-2 text-center border-b">
                                <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                    class="w-16 h-16 mx-auto rounded-full">
                                <h3 class="font-semibold">
                                    Al. {{ $item->students->nick }}
                                </h3>
                                <p>T. {{ $item->students->people_class }}</p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @empty
            <p>Nenhuma ano cadastrado</p>
        @endforelse
    @empty
        <p>Nenhuma companhia cadastrada</p>
    @endforelse
</div>
