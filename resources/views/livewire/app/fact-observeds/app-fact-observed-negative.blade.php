<div
    class="min-h-screen px-6 pt-6 pb-20 bg-gray-100 border-2 rounded-r-lg rounded-bl-lg dark:bg-gray-700 dark:text-gray-100">
    @php
        use App\Enums\FunctionsObserver;
    @endphp
    <form>
        <div role="tabpanel" class="bg-gray-100 dark:bg-gray-700">
            <div class="grid grid-cols-1">
                <div class="bg-gray-100 col-span-full dark:bg-gray-700" wire:ignore>
                    @livewire('app.settings.select-faults', [$faults])
                    @error('faults')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full" wire:ignore>
                    @livewire('app.settings.select-students')
                </div>
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Observador
                    </label>
                    <input type="text" wire:model="fact_observer"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                </div>
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Função do observador
                    </label>
                    <select wire:model="fact_observer_function"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Selecione...</option>
                        @foreach (FunctionsObserver::cases() as $item)
                            <option value="{{ $item->value }}">{{ $item->label() }}</option>
                        @endforeach
                    </select>
                    @error('fact_observer_function')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Data</label>
                    <input type="date" wire:model="fact_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('fact_date')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Hora</label>
                    <input type="time" wire:model="fact_hour"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('fact_hour')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full sm:col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Relato
                    </label>
                    <textarea wire:model="fact" rows="10"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                    @error('fact')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>
    </form>
    <div class="px-4 pt-5 text-center">
        <button type="submit" wire:click="save"
            class="text-white w-full
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Cadastrar
        </button>
    </div>

</div>
