<div>
    @php
        use App\Enums\TypeContacts;
    @endphp
    <div class="flex justify-center mb-5">
        <span wire:click="addRow"
            class="flex justify-between px-3 py-1 text-white transition-colors duration-200 bg-gray-700 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
            Adicionar contatos <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 " viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 12H20M12 4V20" stroke="CurrentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>
    @foreach ($contacts as $index => $contact)
        @php
            $typeValue = $contacts[$index]['type'] ?? null;
            $mask = $typeValue ? \App\Enums\TypeContacts::from($typeValue)->mask() : null;
            $inputType = $typeValue === 'email' ? 'email' : 'text';
        @endphp
        <div
            class="grid grid-cols-2 gap-4 p-2 mb-1 bg-gray-200 border border-gray-900 rounded-lg sm:grid-cols-6 sm:gap-3 sm:mb-5 dark:bg-gray-800 dark:border-gray-500">
            <div
                class="flex justify-end col-span-6 py-0 my-0 border-b border-gray-900 dark:bg-gray-800 dark:border-white">

                <div class="p-0 tooltip tooltip-top" data-tip="Remover">
                    <span wire:click="removeRow({{ $contacts[$index]['id'] }})"
                        class="flex px-3 py-2 text-red-500 transition-colors duration-200 cursor-pointer hover:text-white whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 12L14 16M14 12L10 16M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="col-span-3">
                <label for="type" class="block text-sm font-medium text-gray-900 dark:text-white">
                    Grau de parentesco
                </label>
                <input type="text" wire:model.lazy="contacts.{{ $index }}.parent"
                    placeholder="Grau de parentesco" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
            <div class="col-span-3">
                <label for="type" class="block text-sm font-medium text-gray-900 dark:text-white">
                    Tipo
                </label>
                <select wire:model.lazy="contacts.{{ $index }}.type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Selecione uma opção</option>
                    @foreach ($typeContacts as $typeContact)
                        <option value="{{ $typeContact->dbName() }}">
                            {{ $typeContact->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <label for="contact" class="block text-sm font-medium text-gray-900 dark:text-white">
                    Contato
                </label>
                <input type="{{ $inputType }}" x-mask="{{ $mask }}"
                    wire:model.lazy="contacts.{{ $index }}.contact" placeholder="Contato" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                @error("contacts.$index.contact")
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>
