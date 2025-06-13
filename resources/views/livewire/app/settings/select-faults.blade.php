<div>
    <div role="tabpanel" class="bg-gray-100  border-base-300 dark:bg-gray-700 dark:text-gray-100">
        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
            <div class="col-span-full ">
                <label class="block text-sm font-medium text-gray-900 dark:text-gray-100" for="title">
                    Falta nº</label>
                <select wire:change="addFaults($event.target.value)" wire:model='selectOption'
                    class="whitespace-pre-line bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Selecione</option>
                    @foreach ($faultsOptions as $value => $label)
                        <option value="{{ $value }}">{{ $value }})
                            {{ mb_strimwidth($label, 0, 100, '...') }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if ($selectedFaults)
                <div class="p-6 mt-5 border-2 rounded-r-lg rounded-bl-lg col-span-full">
                    @foreach ($selectedFaults as $number => $title)
                        <div class="flex-wrap gap-2 badge badge-error ">
                            {{ $number }}) {{ mb_strimwidth($title, 0, 40, '...') }}
                            <svg wire:click="removeFaults({{ $number }})" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                                class="inline-block w-4 h-4 cursor-pointer stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

</div>
