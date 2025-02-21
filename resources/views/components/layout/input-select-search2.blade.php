<div>
    @props(['field' => null, 'query' => [], 'selectedId' => null, 'selectedTitle' => ''])

    <div x-data="{
        open: false,
        search: '{{ $selectedTitle }}',
        filteredQuery: @js($query),
        selectedTitle: '{{ $selectedTitle }}',
        selectedId: '{{ $selectedId }}',
    }" class="relative" x-on:click.away="open = false">
        <!-- Campo de entrada -->
        <input type="text" x-model="search" x-on:focus="open = true"
            x-on:input="filteredQuery = @js($query).filter(item => item.title.toLowerCase().includes(search.toLowerCase()))"
            placeholder="Buscar..."
            class="w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />

        <!-- Input oculto -->
        <input type="hidden" name="{{ $field }}" x-model="selectedId" />

        <!-- Dropdown -->
        <div x-show="open && filteredQuery.length > 0"
            class="absolute z-10 w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            style="display: none;">
            <ul class="overflow-auto max-h-60">
                <template x-for="item in filteredQuery" :key="item.id">
                    <li x-on:click="
                            selectedTitle = item.title;
                            selectedId = item.id;
                            search = item.title;
                            open = false;
                            $wire.set('{{ $field }}', selectedId);"
                        class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white">
                        <span x-text="item.title"></span>
                    </li>
                </template>
            </ul>
        </div>

        <!-- Ícone de seta -->
        <div class="absolute text-gray-500 transform -translate-y-1/2 pointer-events-none right-3 top-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>
