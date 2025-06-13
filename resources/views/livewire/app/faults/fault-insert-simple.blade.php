<div @php
use App\Enums\SchoolFault; @endphp
    class="min-h-screen px-6 pt-6 pb-20 bg-gray-100 border-2 rounded-r-lg rounded-bl-lg border-base-300 dark:bg-gray-700 dark:text-gray-100">
    <form>
        <div role="tabpanel" class="bg-gray-100 dark:bg-gray-900">
            <div class="grid grid-cols-1">
                <div class="col-span-full" wire:ignore>
                    @livewire('faults.school-fault-students', ['class_id' => $school_classes_id, 'array' => true])
                </div>
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="qtd" required>
                        Períodos (qtd)</label>
                    <input type="number" wire:model="qtd" required
                        class="bg-gray-50 text-base border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('qtd')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Data</label>
                    <input type="date" wire:model="date" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('date')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="py-2 col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Justificado?</label>
                    <div class="w-full flex-nowrap justify-stretch">
                        @foreach (SchoolFault::cases() as $item)
                            <div class="p-0 tooltip tooltip-top" data-tip="{{ $item->label() }}">
                                <label
                                    class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                            rounded-md cursor-pointer {{ $item->value == $justified ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                                    <input type="radio" wire:model.live="justified" value="{{ $item->value }}"
                                        class="hidden peer" {{ $item->value == $justified ? 'checked' : '' }}>

                                    <span class="text-xs">
                                        {{ $item->label() }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($justified != 0)
                    <div class="col-span-full ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                            Relato</label>
                        <textarea wire:model="text" rows="5"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>

                        @error('text')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                @if ($companies)
                    <div class="py-2 col-span-full">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                            Companhia:</label>
                        <h2>{{ $companies->name }}</h2>
                    </div>
                @endif

                <div class="py-2 col-span-full">
                    <div class="grid grid-cols-2">
                        @if ($grades)
                            <div class="col-span-1 py-2">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Ano:</label>
                                <h2>{{ $grades->name }}</h2>
                            </div>
                        @endif
                        @if ($classes)
                            <div class="col-span-1 py-2">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Turma:</label>
                                <h2>{{ $classes->title }}</h2>
                            </div>
                        @endif
                    </div>
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
