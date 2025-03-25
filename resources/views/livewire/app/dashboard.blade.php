<div>
    <div class="top-0 left-0 w-full p-3 text-center bg-white border-b shadow-md dark:text-white dark:bg-gray-800 ">
        <div class="flex items-center justify-center space-x-2 dark:text-white dark:bg-gray-800">
            <x-application-logo width="h-8"></x-application-logo>
            <h1 class="text-lg font-bold ">{{ $this->config->nick ?? 'GerenCia' }}</h1>
        </div>
        <p class="text-sm text-gray-500 dark:text-white">Uma descrição ou slogan aqui</p>
    </div>
    <x-app.tabs>
        <x-slot name="content">
            <div id="tab1" x-show="activeTab === '#tab1'" class="block">

                <div class="grid items-center justify-between w-full h-full grid-cols-2 pb-10 mt-10 space-y-2">

                    <div class="flex items-center justify-center col-span-1 ">
                        <a href="#tab2" class="avatar " @click="activeTab = '#tab2'">
                            <div class="w-32 rounded-tr-2xl rounded-bl-2xl dark:bg-blue-300 ">
                                <img src="{{ url('storage/buttons/fo.png') }}" alt="fo" />
                            </div>
                        </a>
                    </div>
                    <div class="flex items-center justify-center col-span-1">
                        <a href="#tab3" class="avatar" @click="activeTab = '#tab3'">
                            <div class="w-32 shadow-lg dark:bg-blue-300 rounded-tr-2xl rounded-bl-2xl ">
                                <img src="{{ url('storage/buttons/falta.png') }}" alt="faltas" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div id="tab2" x-show="activeTab === '#tab2'">
                @livewire('app.fact-observeds.app-fact-observed-form')
            </div>
            <div id="tab3" x-show="activeTab === '#tab3'">
                @livewire('app.user-profile')
            </div>
            <div id="tab4" x-show="activeTab === '#tab3'">
                <div class="prose max-w-none dark:prose-invert">
                    {!! $readmeContent !!}
                </div>
            </div>
        </x-slot>
        <x-slot name="nav">
            <footer
                class="fixed bottom-0 left-0 flex justify-around w-full p-3 bg-white border-t shadow-md dark:bg-gray-800">
                <x-app.tab-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V10z"></path>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Início</x-slot>
                </x-app.tab-nav>
                <x-app.tab-nav>

                    <x-slot name="svg">
                        @if ($darkMode == 1)
                            <!-- moon icon -->
                            <svg wire:click="toggleDarkMode" class="w-6 h-6 dark:text-white"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M3.32031 11.6835C3.32031 16.6541 7.34975 20.6835 12.3203 20.6835C16.1075 20.6835 19.3483 18.3443 20.6768 15.032C19.6402 15.4486 18.5059 15.6834 17.3203 15.6834C12.3497 15.6834 8.32031 11.654 8.32031 6.68342C8.32031 5.50338 8.55165 4.36259 8.96453 3.32996C5.65605 4.66028 3.32031 7.89912 3.32031 11.6835Z"
                                    stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @else
                            <!-- sun icon -->
                            <svg wire:click="toggleDarkMode" class="w-6 h-6 dark:text-white"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                            </svg>
                        @endif
                    </x-slot>
                    <x-slot name="title">Tela</x-slot>
                </x-app.tab-nav>
                <x-app.tab-nav tab="tab3">
                    <x-slot name="svg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7">
                            </path>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Perfil</x-slot>
                </x-app.tab-nav>
                <x-app.tab-nav tab="tab4">
                    <x-slot name="svg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7">
                            </path>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Versão</x-slot>
                </x-app.tab-nav>

            </footer>
        </x-slot>
    </x-app.tabs>

    @script
        <script>
            $wire.on('darkModeToggled', (darkModeArray) => {
                const darkMode = darkModeArray[0];
                if (darkMode) {
                    document.body.classList.add('dark');
                } else {
                    document.body.classList.remove('dark');
                }
            });
        </script>
    @endscript
</div>
