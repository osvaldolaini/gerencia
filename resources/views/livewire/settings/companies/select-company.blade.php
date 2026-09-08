<div class="flex flex-col w-full">

    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
        Selecione uma companhia
    </label>
    <div class="flex flex-wrap gap-3">
        {{-- Todas --}}
        <button type="button" wire:click="selectCompany('all')"
            class="p-1 flex flex-col items-center justify-center w-16 h-16 rounded-lg border transition
                {{ (string) $companyId === 'all'
                    ? 'border-blue-600 bg-blue-100 dark:bg-blue-900'
                    : 'border-gray-300 bg-white dark:bg-gray-800' }}">
            <span class="text-sm font-medium text-gray-700 ">
                {{-- Todas --}}
                @if (Storage::directoryMissing('public/logos-school'))
                    <picture>
                        <source srcset="{{ url('storage/logos/logo-gerencia.png') }}" />
                        <source srcset="{{ url('storage/logos/logo-gerencia.webp') }}" />
                        <img src="{{ url('storage/logos/logo-gerencia.png') }}" alt="api-gerencia">
                    </picture>
                @else
                    <picture>
                        <source srcset="{{ url('storage/logos-school/logo.png') }}" />
                        <source srcset="{{ url('storage/logos-school/logo.webp') }}" />
                        <img src="{{ url('storage/logos-school/logo.png') }}" alt="api-gerencia">
                    </picture>
                @endif
            </span>
        </button>

        @foreach ($companies as $company)
            <button type="button" wire:click="$set('companyId', {{ $company->id }})"
                wire:click="$dispatch('company-selected', { companyId: {{ $company->id }} })"
                class="p-1 flex flex-col items-center justify-center w-16 h-16 rounded-lg border
                   {{ $companyId == $company->id
                       ? 'border-blue-600 bg-blue-100 dark:bg-blue-900'
                       : 'border-gray-300 bg-white dark:bg-gray-800' }}">
                <picture>
                    <source
                        srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}" />
                    <source
                        srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.webp') }}" />
                    <img src="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}"
                        alt="{{ $company->name }}">
                </picture>
            </button>
        @endforeach

    </div>
    <x-layout.loading.select-student></x-layout.loading.select-student>
</div>
