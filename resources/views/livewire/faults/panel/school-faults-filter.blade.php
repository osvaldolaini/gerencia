<div>
    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
        <div class="col-span-full">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="qtd"
                required>Períodos</label>
            @livewire('discipline.input-search')
        </div>
        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">Companhia</label>
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

        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Ano Escolar</label>
            <select wire:model.live="school_grades_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="">Todos</option>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Turma</label>
            <select wire:model.live="school_classes_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="">Todas</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Data Inicial</label>
            <input type="date" wire:model.live="date_start"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>

        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Data Final</label>
            <input type="date" wire:model.live="date_end"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>

        <div class="col-span-full sm:col-span-3">
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Justificado</label>
            <select wire:model.live="justified"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="">Todos</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>
        <div class="col-span-full ">
            <button wire:click="exportPdf" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                Exportar PDF
            </button>

        </div>

    </div>

    <table class="w-full text-sm text-gray-900 table-auto dark:text-gray-100">
        <thead>
            <tr class="text-gray-100 bg-gray-900 dark:bg-gray-100 dark:text-gray-900">
                <th class="px-2 py-1 text-left">Data</th>
                <th class="px-2 py-1 text-left">Aluno</th>
                <th class="px-2 py-1 text-center">Companhia</th>
                <th class="px-2 py-1 text-center">Ano</th>
                <th class="px-2 py-1 text-center">Turma</th>
                <th class="px-2 py-1 text-center">Qtd</th>
                <th class="px-2 py-1 text-center">Justificada</th>
                <th class="px-2 py-1 text-center">Acumulado</th>
                <th class="px-2 py-1 text-center">%</th>
                {{-- <th class="px-2 py-1 text-center">Acumulado total</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($faults as $fault)
                <tr class="border-b">
                    <td class="px-2 py-1">{{ \Carbon\Carbon::parse($fault->date)->format('d/m/Y') }}</td>
                    <td class="px-2 py-1">{{ $fault->students->name ?? '-' }}</td>
                    <td class="px-2 py-1 text-center">{{ $fault->companies->name ?? '-' }}</td>
                    <td class="px-2 py-1 text-center">{{ $fault->grades->name ?? '-' }}</td>
                    <td class="px-2 py-1 text-center">{{ $fault->class->title ?? '-' }}</td>
                    <td class="px-2 py-1 text-center">{{ $fault->qtd }}</td>
                    <td class="px-2 py-1 text-center">
                        <span class="badge {{ $fault->justified ? 'badge-success' : 'badge-error' }}">
                            {{ $fault->justified ? 'Sim' : 'Não' }}
                        </span>
                    </td>
                    <td class="px-2 py-1 font-bold text-center">{{ $fault->acumulado }}</td>
                    <td class="px-2 py-1 font-bold text-center">
                        {{ number_format((($fault->acumulado ?? 0) / 1200) * 100, 2, ',', '') }}%
                    </td>

                    {{-- <td>{{ $acumuladoPeriodo[$fault->students->id] }}</td>
                    <td>{{ $acumuladoTotal[$fault->students->id] ?? 0 }}</td> <!-- acumulado do ano --> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfInNewTab', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection
</div>
