<div
    class="min-h-screen px-6 pt-6 pb-20 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
    <form>
        <div role="tabpanel" class="">
            <div class="grid grid-cols-1">
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                        Companhia</label>
                    <select wire:model.live="companies_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Selecione...</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('companies_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="qtd" required>
                        Períodos (qtd)</label>
                    <input type="number" wire:model="qtd" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
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
                @if ($companies_id)
                    <div class="col-span-full ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                            Ano</label>
                        <select wire:model.live="school_grades_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Selecione...</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                        @error('school_grades_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                @if ($school_grades_id)
                    <div class="col-span-full ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                            Turma</label>
                        <select wire:model.live="school_classes_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Selecione...</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->title }}</option>
                            @endforeach
                        </select>
                        @error('school_classes_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                @if ($school_classes_id)
                    <div class="col-span-full" wire:ignore>
                        @livewire('faults.school-fault-students', ['class_id' => $school_classes_id])
                    </div>
                @endif
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
