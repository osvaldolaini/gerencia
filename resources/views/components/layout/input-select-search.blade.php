<div>
    @props(['field' => null, 'query' => null, 'selectedId' => null, 'selectedTitle' => null])
    <div x-data="{
        open: false,
        selectedTitle: @js($selectedTitle),
        selectedId: '{{ $selectedId }}'
    }" class="relative" x-on:click.away="open = false">


        <!-- O campo de texto já vem pré-preenchido com o valor da edição -->
        <input type="text" x-model="selectedTitle" x-on:focus="open = true"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
        focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10
        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
        dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-pointer" />

        <!-- Campo hidden sem  -->
        <input type="hidden" x-model="selectedId" />

        <!-- Dropdown de sugestões -->
        <div x-show="open" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
            style="display: none;">
            <ul class="overflow-auto rounded-md max-h-60">
                @forelse ($query as $item)
                    <li x-on:click="selectedTitle = '{{ $item->title }}'; selectedId = '{{ $item->id }}'; open = false; $wire.set('{{ $field }}', selectedId);"
                        class="relative p-2 text-gray-900 rounded-md cursor-pointer select-none hover:bg-blue-500 hover:text-white">
                        {{ $item->title }}
                    </li>
                @empty
                    <li
                        class="relative p-2 text-gray-900 rounded-md cursor-pointer select-none hover:bg-blue-500 hover:text-white">
                        Nenhum resultado encontrado
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Ícone da seta -->
        <div class="absolute text-gray-500 transform -translate-y-1/2 pointer-events-none right-3 top-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

</div>
