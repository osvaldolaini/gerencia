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
                        <a href="#tab5" class="avatar" @click="activeTab = '#tab5'">
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
            <div id="tab5" x-show="activeTab === '#tab5'">
                <div class="mx-5">

                    <x-under-construction />
                </div>
            </div>
            <div id="tab3" x-show="activeTab === '#tab3'">
                @livewire('app.user-profile')
            </div>
            <div id="tab4" x-show="activeTab === '#tab4'">
                <div class="mx-5 prose max-w-none dark:prose-invert">
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </x-slot>
                    <x-slot name="title">Perfil</x-slot>
                </x-app.tab-nav>
                <x-app.tab-nav tab="tab4">
                    <x-slot name="svg">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
