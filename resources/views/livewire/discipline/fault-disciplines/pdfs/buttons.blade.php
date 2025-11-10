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
    @endif
    @if ($status == 'lista')
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
