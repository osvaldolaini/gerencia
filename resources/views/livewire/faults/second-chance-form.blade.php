<div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
    <div class="col-span-full sm:col-span-3">
        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="number">
            Nº AP</label>
        <input type="number" wire:model.live.debounce.500ms="number"
            class="bg-gray-50 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        @error('number')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-span-full sm:col-span-3">
        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="discipline">
            Matéria</label>
        <input type="text" wire:model.live.debounce.500ms="discipline"
            class="bg-gray-50 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        @error('discipline')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
</div>
