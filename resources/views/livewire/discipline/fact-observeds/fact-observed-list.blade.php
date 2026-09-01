<div>
    @php
        use Carbon\Carbon;
    @endphp
    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layout.breadcrumb>
    <x-layout.search>
        <x-slot name="button">
            <button wire:click="showCreate()"
                class="flex items-center justify-center p-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg lg:px-5 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span class="">Novo </span>
            </button>
        </x-slot>
    </x-layout.search>
    <div class="grid grid-cols-3 mt-3">
        {{-- <div class="flex flex-col col-span-1">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                Selecione uma companhia </label>
            <select wire:model.lazy="companyId"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="all">Selecione...</option>

                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">
                        {{ $company->nick }}
                    </option>
                @endforeach
            </select>
        </div> --}}
        <div class="flex flex-wrap gap-3">
            <label class="flex w-full text-sm font-medium text-gray-900 dark:text-white" for="title">
                Selecione uma companhia </label>
            {{-- Todas --}}
            <button type="button" wire:click="selectCompany('all')"
                class="p-1 flex flex-col items-center justify-center w-16 h-16 rounded-lg border transition
                {{ (string) $companyId === 'all'
                    ? 'border-blue-600 bg-blue-100 dark:bg-blue-900'
                    : 'border-gray-300 bg-white dark:bg-gray-800' }}">
                <span class="text-sm font-medium text-gray-700 ">
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
    </div>

    <div class="flex pt-5">
        <div class="w-full flex-nowrap justify-stretch">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                Filtros
            </label>
            <div class="p-0 tooltip tooltip-top" data-tip="FO+">
                <label
                    class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                rounded-md cursor-pointer {{ $fact_type == 'negativo' ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                    <input type="radio" wire:model.live="fact_type" value="negativo" class="hidden peer"
                        {{ $fact_type == 'negativo' ? 'checked' : '' }}>

                    <span class="text-xs">
                        FO-
                    </span>
                </label>
            </div>
            <div class="p-0 tooltip tooltip-top" data-tip="FO+">
                <label
                    class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                rounded-md cursor-pointer {{ $fact_type == 'positivo' ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                    <input type="radio" wire:model.live="fact_type" value="positivo" class="hidden peer"
                        {{ $fact_type == 'positivo' ? 'checked' : '' }}>
                    <span class="text-xs">
                        FO+
                    </span>
                </label>
            </div>
            <div class="p-0 tooltip tooltip-top" data-tip="FO+">
                <label
                    class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                rounded-md cursor-pointer {{ $fact_type == 'informativo' ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                    <input type="radio" wire:model.live="fact_type" value="informativo" class="hidden peer"
                        {{ $fact_type == 'informativo' ? 'checked' : '' }}>
                    <span class="text-xs">
                        FO!
                    </span>
                </label>
            </div>
            @if ($fact_type == 'negativo')
                <div class="p-0 tooltip tooltip-top" data-tip="Gerou FAFD?">
                    <span wire:click='btnFafd()'
                        class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                rounded-md cursor-pointer {{ $fafd ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">

                        <span class="text-xs">
                            Gerou FAFD?
                        </span>
                    </span>
                </div>
            @endif
            @if ($fact_type == 'positivo')
                <div class="p-0 tooltip tooltip-top" data-tip="Gerou elogio?">
                    <span wire:click='btnCompliment()'
                        class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                rounded-md cursor-pointer {{ $compliment ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">

                        <span class="text-xs">
                            Gerou elogio?
                        </span>
                    </span>
                </div>
            @endif

            @if ($sincomil_date == true)
                <button wire:click='buttonSee' class="text-green-500 btn btn-outline btn-success btn-sm">
                    Mostrar lançados
                    <svg class="relative w-6 h-6 " viewBox="0 -6 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                transform="translate(-258.000000, -367.000000)" fill="currentColor">
                                <path
                                    d="M280,383 C276.687,383 274,380.313 274,377 C274,373.687 276.687,371 280,371 C283.313,371 286,373.687 286,377 C286,380.313 283.313,383 280,383 L280,383 Z M280,367 L268,367 C262.477,367 258,371.478 258,377 C258,382.522 262.477,387 268,387 L280,387 C285.523,387 290,382.522 290,377 C290,371.478 285.523,367 280,367 L280,367 Z M280,373 C277.791,373 276,374.791 276,377 C276,379.209 277.791,381 280,381 C282.209,381 284,379.209 284,377 C284,374.791 282.209,373 280,373 L280,373 Z"
                                    id="toggle-off" sketch:type="MSShapeGroup">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
            @else
                <button wire:click='buttonSee' class="text-red-500 btn btn-outline btn-error btn-sm">
                    Mostrar lançados
                    <svg class="relative w-6 h-6" viewBox="0 -6 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                transform="translate(-204.000000, -365.000000)" fill="currentColor">
                                <path
                                    d="M214,379 C211.791,379 210,377.209 210,375 C210,372.791 211.791,371 214,371 C216.209,371 218,372.791 218,375 C218,377.209 216.209,379 214,379 L214,379 Z M214,369 C210.687,369 208,371.687 208,375 C208,378.313 210.687,381 214,381 C217.314,381 220,378.313 220,375 C220,371.687 217.314,369 214,369 L214,369 Z M226,383 L214,383 C209.582,383 206,379.418 206,375 C206,370.582 209.582,367 214,367 L226,367 C230.418,367 234,370.582 234,375 C234,379.418 230.418,383 226,383 L226,383 Z M226,365 L214,365 C208.477,365 204,369.478 204,375 C204,380.522 208.477,385 214,385 L226,385 C231.523,385 236,380.522 236,375 C236,369.478 231.523,365 226,365 L226,365 Z"
                                    id="toggle-on" sketch:type="MSShapeGroup">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
            @endif
        </div>

    </div>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($dataTable as $item)
                <div class="mb-10 rounded-md cursor-pointer" wire:key='item-{{ $item->id }}'>
                    <h2 id="w-full text-center items-center">
                        <div type="button"
                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                <div class="flex justify-between pl-2 col-span-full ">
                                    <div class="p-0 tooltip tooltip-top" data-tip="Arraste e solte">
                                        FO <span
                                            class="badge {{ $item->fact_type == 'negativo' ? 'badge-error' : ($item->fact_type == 'positivo' ? 'badge-success' : 'badge-info') }}">
                                            {{ $item->fact_type }}</span> Nº <span>{{ $item->fact_number }}
                                            - ocorrido em {{ $item->f_date . ' às ' . $item->fact_hour }} por
                                            {{ $item->fact_observer . ' ' . $item->fact_observer_function }}.
                                        </span>
                                    </div>

                                    @if ($item->faults != '' or $item->faults != null)
                                        <div class="btn btn-outline btn-accent">
                                            <p>Falta(s) nr</p>
                                            @foreach ($item->json_faults as $faults)
                                                <span class="badge badge-accent ">
                                                    {{ $faults }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-1">
                                    @if ($item->student_id)
                                        @if ($item->students?->logo_path)
                                            <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_big.png') }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <h1 class="text-3xl font-bold">
                                        Al. {{ $item->al_nick }}
                                    </h1>
                                    <div class="max-w-xs">
                                        <p>
                                            nº. {{ $item->al_number }}
                                        </p>
                                        <p>
                                            T. {{ $item->al_class }}
                                        </p>
                                        <p>
                                            @if ($item->students?->company)
                                                <picture>
                                                    <source
                                                        srcset="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.png') }}" />
                                                    <source
                                                        srcset="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.webp') }}" />
                                                    <img src="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.png') }}"
                                                        alt="{{ $item->students?->company->name }}">
                                                </picture>
                                            @else
                                                <span class="badge badge-accent">
                                                    {{ $item->students?->company?->nick ?? '' }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-3">
                                    <ul class="timeline timeline-vertical">
                                        <li>
                                            <div class="timeline-start">
                                                {{ Carbon::createFromFormat('Y-m-d', $item->fact_date)->format('d/m') }}
                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->fact_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>

                                            <a class="timeline-end timeline-box"
                                                href="{{ route('fact-observed-edit', $item->id) }}#tab2">
                                                Lançado
                                            </a>

                                            @if ($item->fact_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                        </li>
                                        @if ($item->fafd)
                                            <li>
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                                <div class="timeline-start">
                                                    @if ($item->updated_at)
                                                        {{ Carbon::createFromFormat('Y-m-d  H:i:s', $item->updated_at)->format('d/m') }}
                                                    @endif
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="w-5 h-5 {{ $item->updated_at ? 'text-success' : '' }}">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>

                                                <a class="timeline-end timeline-box"
                                                    href="{{ route('fault-discipline-edit', $item->fafds->id) }}#tab3">
                                                    Gerou FAFD nº {{ $item->fafds->number }} /
                                                    {{ $item->fafds->year }}
                                                </a>

                                            </li>
                                        @elseif($item->compliment)
                                            <li>
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                                <div class="timeline-start">
                                                    @if ($item->updated_at)
                                                        {{ Carbon::createFromFormat('Y-m-d  H:i:s', $item->updated_at)->format('d/m') }}
                                                    @endif
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="w-5 h-5 {{ $item->updated_at ? 'text-success' : '' }}">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>

                                                <a class="timeline-end timeline-box"
                                                    href="{{ route('compliment-edit', $item->compliments->id) }}#tab3">
                                                    Gerou elogio nº {{ $item->compliments->number }} /
                                                    {{ $item->compliments->year }}
                                                </a>

                                            </li>
                                        @else
                                            <li>
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                                <div class="timeline-start">
                                                    @if ($item->sincomil_date)
                                                        {{ Carbon::createFromFormat('Y-m-d', $item->sincomil_date)->format('d/m') }}
                                                    @endif
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="w-5 h-5 {{ $item->sincomil_date ? 'text-success' : '' }}">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <a class="timeline-end timeline-box"
                                                    href="{{ route('fact-observed-edit', $item->id) }}#tab3">
                                                    SINCOMIL
                                                </a>
                                            </li>
                                        @endif

                                    </ul>

                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <div class="justify-start block space-x-2 space-y-2 font-medium duration-200 ">
                                        <x-layout.table-options id='{{ $item->id }}'
                                            active='{{ $item->status }}'>
                                            @if ($item->fafd == 0 && $item->fact_type != 'positivo')
                                                <x-slot name="extra">

                                                    <div class="p-0 tooltip tooltip-top" data-tip="Gerar FAFD?">
                                                        <button wire:click='showModalFafd({{ $item->id }})'
                                                            class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                            FAFD?
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                viewBox="0 0 48 48"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M40.8992 19.5969L37.1832 11.5456C37.4542 11.2998 37.6712 11.0004 37.8205 10.6664C37.9697 10.3323 38.048 9.97092 38.0503 9.60505C38.048 9.01126 37.8438 8.43592 37.4711 7.97366C37.0984 7.5114 36.5794 7.18974 35.9996 7.06161C35.4198 6.93348 34.8137 7.00649 34.2809 7.26865C33.7481 7.5308 33.3204 7.96648 33.0681 8.50402L14.2818 13.2797C13.8184 12.8811 13.2277 12.6614 12.6165 12.6604C12.0862 12.6568 11.5675 12.8154 11.1299 13.1149C10.6922 13.4144 10.3566 13.8405 10.1679 14.3361C9.97926 14.8317 9.94658 15.3732 10.0743 15.8879C10.202 16.4026 10.4839 16.866 10.8824 17.2159L7.07007 25.4736L18.1492 25.4323L14.3506 17.1746C14.7554 16.8117 15.0348 16.3299 15.1489 15.7983L21.934 14.078V35.2177H21.7963L12.6303 38.0667C12.3371 38.1595 12.0808 38.3425 11.8979 38.5897C11.715 38.8368 11.6149 39.1355 11.6118 39.4429V39.5393C11.5999 39.7328 11.629 39.9266 11.6973 40.1081C11.7655 40.2895 11.8713 40.4545 12.0077 40.5923C12.1442 40.73 12.3081 40.8374 12.489 40.9073C12.6698 40.9772 12.8633 41.0082 13.0569 40.9981H34.9261C35.1185 41.008 35.3108 40.9774 35.4906 40.9083C35.6704 40.8392 35.8337 40.7331 35.9699 40.5969C36.1061 40.4606 36.2122 40.2974 36.2814 40.1175C36.3505 39.9377 36.3811 39.7454 36.3712 39.553V39.4429C36.3691 39.1372 36.271 38.8398 36.0907 38.5929C35.9104 38.3459 35.6571 38.1618 35.3665 38.0667L26.2142 35.2177H26.0628V13.1972L33.3847 11.2566L33.6599 11.5456L29.9302 19.6244C30.7538 19.6244 40.1444 19.5969 40.8992 19.5969ZM9.34094 25.4736L12.6165 18.372L15.8466 25.442L9.34094 25.4736ZM35.4904 12.7017L38.6834 19.5831H32.2561L35.4904 12.7017Z"
                                                                    fill="currentColor" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M12.6198 30.7178C14.9518 30.7178 16.9448 29.2665 17.7449 27.2178C15.8324 27.2178 14.6113 27.2178 13.5733 27.2178C11.8323 27.2179 10.6058 27.2179 7.4948 27.2178C8.29489 29.2665 10.2879 30.7178 12.6198 30.7178ZM5.38946 27.2178C5.21373 26.5811 5.11984 25.9104 5.11984 25.2178C5.86224 25.2178 6.52404 25.2178 7.11984 25.2178C10.5178 25.2179 11.7694 25.2179 13.5851 25.2178C14.687 25.2178 15.9966 25.2178 18.1198 25.2178C18.7175 25.2178 19.3797 25.2178 20.1198 25.2178C20.1198 25.2187 20.1198 25.2196 20.1198 25.2205C20.1196 25.9121 20.0257 26.5819 19.8502 27.2178C18.975 30.389 16.0694 32.7178 12.6198 32.7178C9.17031 32.7178 6.26471 30.389 5.38946 27.2178Z"
                                                                    fill="currentColor" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M35.0256 25.0137C37.3576 25.0137 39.3506 23.5624 40.1506 21.5137C38.2381 21.5137 37.0171 21.5137 35.979 21.5137C34.238 21.5138 33.0115 21.5138 29.9005 21.5137C30.7006 23.5624 32.6936 25.0137 35.0256 25.0137ZM27.7952 21.5137C27.6195 20.877 27.5256 20.2063 27.5256 19.5137C28.268 19.5137 28.9298 19.5137 29.5256 19.5137C32.9236 19.5138 34.1752 19.5138 35.9909 19.5137C37.0927 19.5137 38.4024 19.5137 40.5256 19.5137C41.1233 19.5137 41.7854 19.5137 42.5256 19.5137C42.5256 19.5146 42.5256 19.5155 42.5256 19.5164C42.5253 20.208 42.4315 20.8778 42.256 21.5137C41.3807 24.6849 38.4751 27.0137 35.0256 27.0137C31.576 27.0137 28.6704 24.6849 27.7952 21.5137Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </button>
                                                    </div>


                                                    <div class="p-0 tooltip tooltip-top" data-tip="Ver FO">

                                                        <button wire:click='showRead({{ $item->id }})'
                                                            class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="12" cy="12" r="2.5"
                                                                    stroke="currentColor" />
                                                                <path
                                                                    d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z"
                                                                    stroke="currentColor" />
                                                                <path
                                                                    d="M17.5 3.5H17.7C19.4913 3.5 20.387 3.5 20.9435 4.0565C21.5 4.61299 21.5 5.50866 21.5 7.3V7.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M17.5 20.5H17.7C19.4913 20.5 20.387 20.5 20.9435 19.9435C21.5 19.387 21.5 18.4913 21.5 16.7V16.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M6.5 3.5H6.3C4.50866 3.5 3.61299 3.5 3.0565 4.0565C2.5 4.61299 2.5 5.50866 2.5 7.3V7.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M6.5 20.5H6.3C4.50866 20.5 3.61299 20.5 3.0565 19.9435C2.5 19.387 2.5 18.4913 2.5 16.7V16.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </x-slot>
                                            @endif
                                            @if ($item->compliment == 0 && $item->fact_type == 'positivo')
                                                <x-slot name="extra">
                                                    <div class="p-0 tooltip tooltip-top" data-tip="Gerar Elogio?">
                                                        <button wire:click='showModalCompliment({{ $item->id }})'
                                                            class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                            Elogio?
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                viewBox="0 0 48 48"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M40.8992 19.5969L37.1832 11.5456C37.4542 11.2998 37.6712 11.0004 37.8205 10.6664C37.9697 10.3323 38.048 9.97092 38.0503 9.60505C38.048 9.01126 37.8438 8.43592 37.4711 7.97366C37.0984 7.5114 36.5794 7.18974 35.9996 7.06161C35.4198 6.93348 34.8137 7.00649 34.2809 7.26865C33.7481 7.5308 33.3204 7.96648 33.0681 8.50402L14.2818 13.2797C13.8184 12.8811 13.2277 12.6614 12.6165 12.6604C12.0862 12.6568 11.5675 12.8154 11.1299 13.1149C10.6922 13.4144 10.3566 13.8405 10.1679 14.3361C9.97926 14.8317 9.94658 15.3732 10.0743 15.8879C10.202 16.4026 10.4839 16.866 10.8824 17.2159L7.07007 25.4736L18.1492 25.4323L14.3506 17.1746C14.7554 16.8117 15.0348 16.3299 15.1489 15.7983L21.934 14.078V35.2177H21.7963L12.6303 38.0667C12.3371 38.1595 12.0808 38.3425 11.8979 38.5897C11.715 38.8368 11.6149 39.1355 11.6118 39.4429V39.5393C11.5999 39.7328 11.629 39.9266 11.6973 40.1081C11.7655 40.2895 11.8713 40.4545 12.0077 40.5923C12.1442 40.73 12.3081 40.8374 12.489 40.9073C12.6698 40.9772 12.8633 41.0082 13.0569 40.9981H34.9261C35.1185 41.008 35.3108 40.9774 35.4906 40.9083C35.6704 40.8392 35.8337 40.7331 35.9699 40.5969C36.1061 40.4606 36.2122 40.2974 36.2814 40.1175C36.3505 39.9377 36.3811 39.7454 36.3712 39.553V39.4429C36.3691 39.1372 36.271 38.8398 36.0907 38.5929C35.9104 38.3459 35.6571 38.1618 35.3665 38.0667L26.2142 35.2177H26.0628V13.1972L33.3847 11.2566L33.6599 11.5456L29.9302 19.6244C30.7538 19.6244 40.1444 19.5969 40.8992 19.5969ZM9.34094 25.4736L12.6165 18.372L15.8466 25.442L9.34094 25.4736ZM35.4904 12.7017L38.6834 19.5831H32.2561L35.4904 12.7017Z"
                                                                    fill="currentColor" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M12.6198 30.7178C14.9518 30.7178 16.9448 29.2665 17.7449 27.2178C15.8324 27.2178 14.6113 27.2178 13.5733 27.2178C11.8323 27.2179 10.6058 27.2179 7.4948 27.2178C8.29489 29.2665 10.2879 30.7178 12.6198 30.7178ZM5.38946 27.2178C5.21373 26.5811 5.11984 25.9104 5.11984 25.2178C5.86224 25.2178 6.52404 25.2178 7.11984 25.2178C10.5178 25.2179 11.7694 25.2179 13.5851 25.2178C14.687 25.2178 15.9966 25.2178 18.1198 25.2178C18.7175 25.2178 19.3797 25.2178 20.1198 25.2178C20.1198 25.2187 20.1198 25.2196 20.1198 25.2205C20.1196 25.9121 20.0257 26.5819 19.8502 27.2178C18.975 30.389 16.0694 32.7178 12.6198 32.7178C9.17031 32.7178 6.26471 30.389 5.38946 27.2178Z"
                                                                    fill="currentColor" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M35.0256 25.0137C37.3576 25.0137 39.3506 23.5624 40.1506 21.5137C38.2381 21.5137 37.0171 21.5137 35.979 21.5137C34.238 21.5138 33.0115 21.5138 29.9005 21.5137C30.7006 23.5624 32.6936 25.0137 35.0256 25.0137ZM27.7952 21.5137C27.6195 20.877 27.5256 20.2063 27.5256 19.5137C28.268 19.5137 28.9298 19.5137 29.5256 19.5137C32.9236 19.5138 34.1752 19.5138 35.9909 19.5137C37.0927 19.5137 38.4024 19.5137 40.5256 19.5137C41.1233 19.5137 41.7854 19.5137 42.5256 19.5137C42.5256 19.5146 42.5256 19.5155 42.5256 19.5164C42.5253 20.208 42.4315 20.8778 42.256 21.5137C41.3807 24.6849 38.4751 27.0137 35.0256 27.0137C31.576 27.0137 28.6704 24.6849 27.7952 21.5137Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </button>
                                                    </div>


                                                    <div class="p-0 tooltip tooltip-top" data-tip="Ver FO">

                                                        <button wire:click='showRead({{ $item->id }})'
                                                            class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="12" cy="12" r="2.5"
                                                                    stroke="currentColor" />
                                                                <path
                                                                    d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z"
                                                                    stroke="currentColor" />
                                                                <path
                                                                    d="M17.5 3.5H17.7C19.4913 3.5 20.387 3.5 20.9435 4.0565C21.5 4.61299 21.5 5.50866 21.5 7.3V7.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M17.5 20.5H17.7C19.4913 20.5 20.387 20.5 20.9435 19.9435C21.5 19.387 21.5 18.4913 21.5 16.7V16.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M6.5 3.5H6.3C4.50866 3.5 3.61299 3.5 3.0565 4.0565C2.5 4.61299 2.5 5.50866 2.5 7.3V7.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                                <path
                                                                    d="M6.5 20.5H6.3C4.50866 20.5 3.61299 20.5 3.0565 19.9435C2.5 19.387 2.5 18.4913 2.5 16.7V16.5"
                                                                    stroke="currentColor" stroke-linecap="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </x-slot>
                                            @endif

                                        </x-layout.table-options>
                                    </div>
                                    @if ($item->faults != '' or $item->faults != null)
                                        <div class="btn btn-outline btn-error">
                                            <p>Reincidente na(s) falta(s) nr</p>
                                            @foreach ($item->json_faults as $faults)
                                                @if ($item->reincident($faults, $item->fact_date, $item->student_id) > 0)
                                                    <span class="badge badge-error">
                                                        {{ $faults }}
                                                        ({{ $item->reincident($faults, $item->fact_date, $item->student_id) }}x)
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="">
                                        <p>Data lançamento SINCOMIL</p>
                                        @livewire('discipline.fact-observeds.sincomil-date', ['fact_observed' => $item], key($item->id))
                                    </div>

                                </div>
                            </div>
                        </div>
                    </h2>
                </div>
            @endforeach
            <div class="items-center justify-between py-4">
                {{ $dataTable->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <x-confirmation-modal wire:model="showJetModal">
        <x-slot name="title">
            Excluir registro
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente excluir o registro?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{ $id }})" wire:loading.attr="disabled">
                Apagar registro
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
    {{-- MODAL FAFD --}}
    <x-confirmation-modal wire:model="modalFafd">
        <x-slot name="title">
            Gerar FAFD
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja gerar uma FAFD?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalFafd')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="fafd_create({{ $id }})"
                wire:loading.attr="disabled">
                Criar FAFD
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
    {{-- MODAL Elogio --}}
    <x-confirmation-modal wire:model="modalCompliment">
        <x-slot name="title">
            Gerar Elogio
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja gerar um elogio?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalCompliment')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="compliment_create({{ $id }})"
                wire:loading.attr="disabled">
                Criar elogio
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showReadModal">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($read)
                    <div
                        class="flex flex-col w-full p-6 space-y-4 text-gray-500 divide-y dark:divide-gray-300 dark:bg-gray-800 dark:text-gray-500">
                        <div
                            class="flex flex-col w-full p-6 space-y-4 text-gray-500 divide-y dark:divide-gray-300 dark:text-gray-500">
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Aluno </span>
                                <span class="dark:text-gray-500">Nr</span>
                                <span class="text-xs">{{ $read->al_nick }}</span>
                                <span class="text-xs">{{ $read->al_number }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Data </span>
                                <span class="dark:text-gray-500">Hora</span>
                                <span class="text-xs">{{ $read->f_date }}</span>
                                <span class="text-xs">{{ $read->fact_hour }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Observador</span>
                                <span class="dark:text-gray-500">Função</span>
                                <span class="text-xs">{{ $read->fact_observer }}</span>
                                <span class="text-xs">{{ strtoupper($read->fact_observer_function) }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="col-span-2 dark:text-gray-500">Fato</span>
                                <span class="col-span-2 text-xs ">{{ $read->fact }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showReadModal')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    {{-- MODAL FORM --}}

    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($fact_observed)
                @livewire('discipline.fact-observeds.fact-observed-form', ['fact_observed' => $fact_observed], key($fact_observed->id))
            @else
                @livewire('discipline.fact-observeds.fact-observed-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>


</div>
