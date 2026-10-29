<div class="container px-4 pb-6 mx-auto">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        military: {
                            900: '#0f1f1a',
                            800: '#1a332b',
                            700: '#234238',
                            gold: '#c9a227',
                            goldLight: '#e0c35a'
                        }
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'float-delayed': 'float 4s ease-in-out 1.5s infinite',
                        'bounce-slow': 'bounce 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-12px)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <section wire:click='showRead'
        class="relative w-full overflow-hidden rounded-md cursor-pointer bg-gradient-to-r from-military-900 via-military-800 to-military-700 ">

        <!-- Balões -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Balão esquerdo -->
            <div class="absolute top-3 left-6 sm:left-12 animate-float opacity-90">
                <svg width="36" height="54" viewBox="0 0 48 72" fill="none">
                    <path d="M24 4C13.5 4 5 13.5 5 25C5 36 13.5 48 24 52C34.5 48 43 36 43 25C43 13.5 34.5 4 24 4Z"
                        fill="#e0c35a" />
                    <path d="M24 52L22 68H26L24 52Z" fill="#c9a227" />
                    <circle cx="18" cy="20" r="4" fill="white" opacity="0.4" />
                </svg>
            </div>

            <!-- Balão direito -->
            <div class="absolute top-2 right-8 sm:right-16 animate-float-delayed opacity-80">
                <svg width="30" height="46" viewBox="0 0 40 64" fill="none">
                    <path d="M20 2C11 2 4 11 4 21C4 31 11 41 20 45C29 41 36 31 36 21C36 11 29 2 20 2Z" fill="#ffffff" />
                    <path d="M20 45L18.5 60H21.5L20 45Z" fill="#d1d5db" />
                    <circle cx="15" cy="16" r="3.5" fill="white" opacity="0.5" />
                </svg>
            </div>

            <!-- Balão pequeno extra -->
            <div class="absolute hidden bottom-2 left-1/3 animate-float opacity-70 sm:block">
                <svg width="24" height="36" viewBox="0 0 48 72" fill="none">
                    <path d="M24 4C13.5 4 5 13.5 5 25C5 36 13.5 48 24 52C34.5 48 43 36 43 25C43 13.5 34.5 4 24 4Z"
                        fill="#e0c35a" />
                    <path d="M24 52L22 68H26L24 52Z" fill="#c9a227" />
                </svg>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="relative max-w-6xl px-6 py-8 mx-auto sm:py-9">
            <h1 class="text-2xl font-bold tracking-tight text-center text-white sm:text-3xl md:text-4xl">
                Aniversariantes <span class="text-military-gold">da Semana</span>
            </h1>
        </div>

        <!-- Linha dourada inferior -->
        <div
            class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-military-gold to-transparent">
        </div>
    </section>
    @if ($showModalRead)
        <div class="mt-4">
            <!-- CTA Buttons -->
            <div class="grid grid-cols-2">

                @livewire('settings.companies.select-company')

                <div class="text-right justify-items-end">
                    <div class="p-0 tooltip tooltip-top" data-tip="Fechar">
                        <button wire:click="closeRead"
                            class="flex px-3 py-2 font-semibold duration-200 shadow-lg rounded-xl bg-military-gold hover:bg-military-goldLight text-military-900 shadow-military-gold/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.9393 12L6.9696 15.9697L8.03026 17.0304L12 13.0607L15.9697 17.0304L17.0304 15.9697L13.0607 12L17.0303 8.03039L15.9696 6.96973L12 10.9393L8.03038 6.96973L6.96972 8.03039L10.9393 12Z"
                                    fill="currentColor" />
                            </svg>
                            Fechar
                        </button>
                    </div>
                </div>


            </div>

            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($birthdays->isEmpty())
                    <div class="alert">
                        <span>Não há aniversariantes cadastrados nesta semana.</span>
                    </div>
                @else
                    <div class="overflow-x-auto border rounded-lg border-base-300">
                        <table class="table w-full ">
                            <thead>
                                <tr class="text-white">

                                    <th>Aluno/a</th>
                                    <th>Idade</th>
                                    <th>Turma</th>
                                    <th>Dia</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($companyId == 'all')
                                    @foreach ($birthdays as $person)
                                        <tr>
                                            <td
                                                class="flex flex-col items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">

                                                @if ($person->code_image)
                                                    <div class="avatar">
                                                        <div class="relative w-8 rounded-full cursor-pointer">
                                                            <!-- Avatar pequeno -->
                                                            <img src="{{ url('storage/student/' . $person->id . '/' . $person->code_image . '_list.png') }}"
                                                                alt="{{ $person->name }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="avatar">
                                                        <div class="relative w-8 rounded-full cursor-pointer">
                                                            <x-application-logo width="h-12"></x-application-logo>
                                                        </div>
                                                    </div>
                                                @endif

                                                <span
                                                    class="{{ $person->sex == 'M' ? 'text-blue-500' : 'text-red-500' }}">
                                                    {{ $person->nick ?? ($person->name ?? 'Sem nome') }} <br />
                                                    {{ $person->num }}
                                                </span>
                                            </td>


                                            <td>
                                                {{ $person->nick ?? ($person->name ?? 'Sem nome') }}
                                            </td>



                                            <td>
                                                {{ $person->age }} anos
                                            </td>
                                            <td>
                                                {{ $person->people_class }}
                                            </td>
                                            <td class="font-bold">
                                                {{ $person->birthday_day }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($birthdays as $person)
                                        @if ($person->company->id == $companyId && $companyId != 'all')
                                            <tr>

                                                <td
                                                    class="flex flex-col px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 items-left dark:text-gray-400">

                                                    @if ($person->code_image)
                                                        <div class="avatar">
                                                            <div class="relative w-8 rounded-full cursor-pointer">
                                                                <!-- Avatar pequeno -->
                                                                <img src="{{ url('storage/student/' . $person->id . '/' . $person->code_image . '_list.png') }}"
                                                                    alt="{{ $person->name }}">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="avatar">
                                                            <div class="relative w-8 rounded-full cursor-pointer">
                                                                <x-application-logo width="h-12"></x-application-logo>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <span
                                                        class="{{ $person->sex == 'M' ? 'text-blue-500' : 'text-red-500' }}">
                                                        {{ $person->nick ?? ($person->name ?? 'Sem nome') }} <br />
                                                        {{ $person->num }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ $person->age }} anos
                                                </td>
                                                <td>
                                                    {{ $person->people_class }}
                                                </td>
                                                <td class="font-bold">
                                                    {{ $person->birthday_day }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                @endif
            </dl>
        </div>
    @endif

</div>
