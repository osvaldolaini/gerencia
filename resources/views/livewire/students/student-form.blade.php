<div>
    <form>
        <x-layout.tabs>
            <x-slot name="nav">
                <x-layout.tabs-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </x-slot>
                    <x-slot name="title">{{ $breadcrumb }}</x-slot>
                </x-layout.tabs-nav>

                <x-layout.button-back route="{{ $back }}"></x-layout.button-back>
            </x-slot>
            <x-slot name="content">
                <div id="tab1" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                                    Nome</label>
                                <input type="text" wire:model="name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Nome aluno</label>
                                <input type="text" wire:model="nick"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('nick')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-3 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Nº aluno</label>
                                <input type="text" wire:model="number" minlength="5"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('number')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-layout.tabs>
    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button>
        <button type="submit" wire:click="save_out"
            class="text-white
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Salvar e sair
        </button>
    </div>
</div>
