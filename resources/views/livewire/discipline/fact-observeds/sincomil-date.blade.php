<div class="col-span-full sm:col-span-1">

    <input type="date" wire:model.live.debounce.500ms="sincomil_date"
        class="bg-gray-50 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    @error('sincomil_date')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
