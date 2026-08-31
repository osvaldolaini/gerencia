<div class="grid w-full grid-cols-3">
    @if ($status == 'aguardando')
        <div class="flex flex-row w-full col-span-1">
            <div class="p-0 tooltip tooltip-top" wire:click='justify()' data-tip="Justificativa" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8"></x-layout.svg.pdf>
                </button>
            </div>
            <div class="p-0 tooltip tooltip-top" wire:click='solution()' data-tip="Solução" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8"></x-layout.svg.pdf>
                </button>
            </div>
            <div class="p-0 tooltip tooltip-top" wire:click='publi()' data-tip="Publicação" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8"></x-layout.svg.pdf>
                </button>
            </div>
        </div>
        <div class="flex flex-col w-full col-span-3 mt-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                Selecione uma companhia </label>
            <div class="flex flex-wrap gap-3">

                {{-- Todas --}}
                <button type="button" wire:click="selectCompany('all')"
                    class="flex flex-col items-center justify-center w-16 h-16 rounded-lg border transition
                        {{ (string) $companyId === 'all'
                            ? 'border-blue-600 bg-blue-100 dark:bg-blue-900'
                            : 'border-gray-300 bg-white dark:bg-gray-800' }}">
                    <span class="text-sm font-medium text-gray-700 ">
                        Todas
                    </span>
                </button>

                @foreach ($companies as $company)
                    <button type="button" wire:click="$set('companyId', {{ $company->id }})"
                        wire:click="$dispatch('company-selected', { companyId: {{ $company->id }} })"
                        class="p-1 flex flex-col items-center justify-center w-16 h-16 rounded-lg border
                           {{ $companyId == $company->id
                               ? 'border-blue-600 bg-blue-100 dark:bg-blue-900'
                               : 'border-gray-300 bg-white dark:bg-gray-800' }}">

                        <picture>
                            <source
                                srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}" />
                            <source
                                srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.webp') }}" />
                            <img src="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}"
                                alt="{{ $company->name }}">
                        </picture>
                    </button>
                @endforeach

            </div>
            {{-- <select wire:model.lazy="companyId"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="all">Selecione...</option>

                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">
                        {{ $company->nick }}
                    </option>
                @endforeach
            </select> --}}
        </div>
    @endif

    @if ($status == 'lista')
        <div class="w-full col-span-1">
            <select wire:model.lazy='year'
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="" active>Selecione... </option>
                @foreach ($years as $key => $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full col-span-1">
            <div class="p-0 tooltip tooltip-top" wire:click='allData()' data-tip="Todas" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8"></x-layout.svg.pdf>
                </button>
            </div>
        </div>
    @endif
    @if ($status == 'aditamentos')
        <div class="w-full col-span-1">
            <select wire:model.lazy='year'
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="" active>Selecione...</option>
                @foreach ($years as $key => $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full col-span-1">
            <select wire:model='supplement' wire:change='published()'
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="" active>Selecione...</option>
                @foreach ($supplements as $key => $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    @endif


    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfInNewTabClasses', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection
</div>
