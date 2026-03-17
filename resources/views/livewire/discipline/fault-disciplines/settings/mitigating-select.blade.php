<div>
    <div role="tabpanel"
        class="p-6 mt-5 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                    Atenuante</label>
                <select wire:change="addMitigating($event.target.value)" wire:model="mitigat"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Selecione</option>
                    @foreach ($mitigatingOptions as $value => $label)
                        <option value="{{ $value }}">{{ $value }}) {{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="rounded-md col-span-full">
                @foreach ($selectedMitigating as $value => $label)
                    <div class="gap-2 badge badge-info ">
                        {{ $value }}) {{ $label }}
                        <svg wire:click="removeMitigating({{ $value }})" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24"
                            class="inline-block w-4 h-4 cursor-pointer stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
