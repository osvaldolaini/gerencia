<div x-data="{ openDropdown: null }" :class="{ 'block': open, 'hidden': !open }"
    class="hidden transition-all duration-300 ease-in-out sm:flex">
    <div class="relative flex flex-col justify-between w-64 h-screen bg-white dark:bg-gray-800">
        <nav class="mt-5 space-y-1">
            <x-layout.side-bar-nav-link url="dashboard" active="*dashboard*" access_page="peoples">
                <x-slot name="svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                    </svg>
                </x-slot>
                <x-slot name="title">
                    Dashboard
                </x-slot>
            </x-layout.side-bar-nav-link>

            {{-- CADASTROS --}}
            <div x-init="if (window.location.href.includes('cadastros')) { openDropdown = 1; }">
                <button @click="openDropdown === 1 ? openDropdown = null : openDropdown = 1"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Cadastros
                    </span>
                    <svg :class="openDropdown === 1 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 1" x-collapse>
                    <x-layout.side-bar-nav-link url="users-list" active="*usuários*" access_page="users">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Usuários
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
                <div x-show="openDropdown === 1" x-collapse>
                    <x-layout.side-bar-nav-link url="peoples-list" active="*efetivo*" access_page="peoples">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Efetivo
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
                <div x-show="openDropdown === 1" x-collapse>
                    <x-layout.side-bar-nav-link url="student-list" active="*alunos*" access_page="students">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Alunos
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
            </div>
            {{-- CORPO DE ALUNOS --}}
            <div x-init="if (window.location.href.includes('legiao-de-honra') || window.location.href.includes('guarda-bandeira')) { openDropdown = 3; }">
                <button @click="openDropdown === 9 ? openDropdown = null : openDropdown = 9"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Corpo de Alunos
                    </span>
                    <svg :class="openDropdown === 9 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 9" x-collapse>
                    <x-layout.side-bar-nav-link url="legion-list" active="*legiao*" access_page="legionOfHonor">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Legião de Honra
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>

            </div>
            {{-- COMPANHIAS --}}
            <div x-init="if (window.location.href.includes('companhias') || window.location.href.includes('batalhao')) { openDropdown = 3; }">
                <button @click="openDropdown === 3 ? openDropdown = null : openDropdown = 3"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Companhias
                    </span>
                    <svg :class="openDropdown === 3 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 3" x-collapse>
                    <x-layout.side-bar-nav-link url="companies-list" active="*usuários*" access_page="companies">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Criar companhia
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
                <div x-show="openDropdown === 3" x-collapse>
                    <x-layout.side-bar-nav-link url="school-grades-list" active="*ano-escolar*"
                        access_page="school_grades">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Criar ano escolar
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
                <div x-show="openDropdown === 3" x-collapse>
                    <x-layout.side-bar-nav-link url="school-classes-years-list" active="*companias/anos*"
                        access_page="school_classes_years">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Criar turmas
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
                <div x-show="openDropdown === 3" x-collapse>
                    <x-layout.side-bar-nav-link url="school-battalion-list" active="*batalhao*"
                        access_page="school_battalion">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Criar batalhão
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
            </div>
            {{-- DISCIPLINA --}}
            <div x-init="if (window.location.href.includes('disciplina')) { openDropdown = 4; }">
                <button @click="openDropdown === 4 ? openDropdown = null : openDropdown = 4"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <div class="indicator" wire:click='view()'>
                            @if ($fo > 0)
                                <span class="indicator-item-bottom badge badge-error"></span>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300" fill="none"
                                viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                        </div>


                        Disciplina
                    </span>
                    <svg :class="openDropdown === 4 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="openDropdown === 4" x-collapse>
                    <x-layout.side-bar-nav-link url="fact-observed-panel" active="*painel-disciplina*"
                        access_page="fact_observed">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Painel
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="fact-observed-list" active="*fato-observado*"
                        access_page="fact_observed">
                        <x-slot name="svg">
                            <div class="indicator" wire:click='view()'>
                                @if ($fo > 0)
                                    <span class="indicator-item-bottom badge badge-error"></span>
                                @elseif($foo > 0)
                                    <span class="indicator-item-bottom badge badge-success"></span>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" viewBox="0 0 48 48"
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
                            </div>

                        </x-slot>
                        <x-slot name="title">
                            FO
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="fault-discipline-list" active="*falta-disciplinar*"
                        access_page="fault_discipline">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" viewBox="0 0 48 48"
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
                        </x-slot>
                        <x-slot name="title">
                            FAFD
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="compliment-list" active="*elogios*" access_page="compliment">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" viewBox="0 0 48 48"
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
                        </x-slot>
                        <x-slot name="title">
                            Elogios
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="faults-list" active="*s/falta*" access_page="faults">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" viewBox="0 0 48 48"
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
                        </x-slot>
                        <x-slot name="title">
                            Falta nº
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>

            </div>
            {{-- Faltas escolares --}}
            <div x-init="if (window.location.href.includes('faltas-escolares')) { openDropdown = 7; }">
                <button @click="openDropdown === 7 ? openDropdown = null : openDropdown = 7"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Faltas
                    </span>
                    <svg :class="openDropdown === 7 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 7" x-collapse>

                    <x-layout.side-bar-nav-link url="school-faults-panel" active="*painel-faltas*"
                        access_page="school_faults">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Painel
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="school-faults-list" active="*lançar-faltas*"
                        access_page="school_faults">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>

                        </x-slot>
                        <x-slot name="title">
                            Lançar Faltas
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="school-faults-filter" active="*busca-avançada*"
                        access_page="school_faults">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Busca Avançada
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="school-faults-more" active="*mais-faltas*"
                        access_page="school_faults">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Alunos > 7,5%
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
            </div>
            {{-- Atividades extra classe --}}
            <div x-init="if (window.location.href.includes('atividades-extra-classe')) { openDropdown = 8; }">
                <button @click="openDropdown === 8 ? openDropdown = null : openDropdown = 8"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <x-layout.svg.activities class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300" />

                        Extraclasse
                    </span>
                    <svg :class="openDropdown === 8 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 8" x-collapse>

                    <x-layout.side-bar-nav-link url="extra-activity-list" active="*/atividade"
                        access_page="extra_activities">
                        <x-slot name="svg">
                            <x-layout.svg.activities class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" />
                        </x-slot>
                        <x-slot name="title">
                            Atividades extra
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="extra-modality-list" active="*modalidade*"
                        access_page="extra_modalities">
                        <x-slot name="svg">
                            <x-layout.svg.activities class="w-6 h-6 ml-2 mr-2 text-gray-500 dark:text-gray-300" />
                        </x-slot>
                        <x-slot name="title">
                            Modalidades
                        </x-slot>
                    </x-layout.side-bar-nav-link>

                </div>
            </div>

            {{-- ADMINISTRAÇÃO --}}
            <div x-init="if (window.location.href.includes('configurações-gerais')) { openDropdown = 2; }">
                <button @click="openDropdown === 2 ? openDropdown = null : openDropdown = 2"
                    class="flex items-center justify-between w-full px-2 py-1 text-left text-gray-700 transition dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                        Administração
                    </span>
                    <svg :class="openDropdown === 2 ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-500 transition-transform duration-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openDropdown === 2" x-collapse>
                    <x-layout.side-bar-nav-link url="settings" active="*configurações-gerais*"
                        access_page="settings">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                        </x-slot>
                        <x-slot name="title">
                            Configurações
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="document-signers-list" active="*assinaturas*"
                        access_page="signatures">
                        <x-slot name="svg">
                            <svg fill="currentColor" class="ml-2 size-6" viewBox="0 0 14 14" role="img"
                                focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m 1.0324444,11.139308 c 0.0179,-0.1218 0.061,-0.2215 0.0958,-0.2215 0.0348,0 0.0633,-0.064 0.0633,-0.1428 0,-0.079 0.0321,-0.1428 0.0714,-0.1428 0.0393,0 0.0714,-0.064 0.0714,-0.1427 0,-0.079 0.0321,-0.1428 0.0714,-0.1428 0.0393,0 0.0714,-0.047 0.0714,-0.1045 0,-0.058 0.08,-0.2479001 0.17776,-0.4230001 0.12606,-0.2258 0.16557,-0.3794 0.13583,-0.528 -0.0254,-0.1269 0.002,-0.2942 0.0687,-0.4236 0.0608,-0.1177 0.18066,-0.4193 0.26627,-0.6702 0.0856,-0.251 0.17774,-0.4885 0.20472,-0.5277 0.027,-0.039 0.0925,-0.216 0.14571,-0.3927 0.0532,-0.1766 0.1232,-0.3517 0.15563,-0.389 0.0324,-0.037 0.059,-0.1417 0.059,-0.232 0,-0.09 0.0321,-0.1642 0.0714,-0.1642 0.0393,0 0.0714,-0.094 0.0714,-0.21 0,-0.1154 0.0321,-0.2298 0.0714,-0.254 0.0393,-0.024 0.073,-0.099 0.0749,-0.1649 0.002,-0.066 0.16547,-0.2492 0.36338,-0.4062 0.1979,-0.1571 0.43577,-0.3579 0.5286,-0.4462 0.0928,-0.088 0.1866,-0.1606 0.20838,-0.1606 0.0218,0 0.13637,-0.093 0.25466,-0.2056 0.11829,-0.113 0.3509,-0.2977 0.51691,-0.4104 0.16601,-0.1128 0.31254,-0.2291 0.32563,-0.2585 0.0131,-0.029 0.0683,-0.053 0.12276,-0.053 0.0544,0 0.21335,-0.064 0.35316,-0.1428 0.26925,-0.1512 0.60679,-0.1909 0.60679,-0.071 0,0.039 0.0421,0.071 0.0936,0.071 0.0515,0 0.15589,0.058 0.23201,0.1285 0.24872,0.231 0.37942,0.24 0.55068,0.038 0.30396,-0.3586 1.0957,-1.1308 1.25041,-1.2194 0.18638,-0.1068 0.51461,-0.1182 0.51461,-0.018 0,0.039 0.043,0.071 0.0956,0.071 0.12754,0 0.26131,0.3072 0.26131,0.6002 0,0.2369 -0.24982,0.6817 -0.50955,0.9073 -0.0731,0.063 -0.13294,0.139 -0.13294,0.1677 0,0.029 -0.0964,0.1422 -0.21416,0.2523 -0.23429,0.2188 -0.26247,0.3229 -0.12217,0.4512 0.18171,0.1662 0.89017,0.5482 1.01669,0.5482 0.0577,0 0.10491,0.029 0.10491,0.063 0,0.035 0.20949,0.1202 0.46554,0.1895 0.4572796,0.1237 0.4683696,0.1234 0.6246396,-0.018 0.1522,-0.1379 0.20395,-0.1411 1.19421,-0.074 0.56932,0.038 1.0438,0.078 1.05441,0.087 0.0106,0.01 0.0719,0.2706 0.13625,0.5806 0.22137,1.0669 0.1397,2.7256 -0.19548,3.9704001 l -0.0726,0.2698 -1.10376,0 -1.10375,0 0,-0.2142 c 0,-0.1178 -0.0321,-0.2142 -0.0714,-0.2142 -0.0393,0 -0.0714,-0.068 -0.0714,-0.1504 0,-0.1163 -0.0283,-0.1381 -0.12493,-0.096 -0.0687,0.03 -0.2373696,0.067 -0.3747896,0.083 -0.13742,0.016 -0.31799,0.063 -0.40128,0.1034 -0.15948,0.078 -0.59017,0.053 -1.4191,-0.084 -0.56756,-0.093 -0.48797,-0.091 -1.12627,-0.028 -0.26608,0.026 -0.50088,0.076 -0.52177,0.1096 -0.0539,0.087 -1.79571,0.078 -1.84994,-0.01 -0.0243,-0.039 -0.15276,-0.071 -0.28555,-0.071 -0.13279,0 -0.26128,-0.032 -0.28555,-0.071 -0.0243,-0.039 -0.15836,-0.071 -0.29798,-0.071 -0.20152,0 -0.30517,0.055 -0.50271,0.2677 -0.13687,0.1473 -0.29749,0.34 -0.35693,0.4284 -0.0594,0.088 -0.16674,0.1606 -0.23843,0.1606 -0.0717,0 -0.15021,0.032 -0.17447,0.071 -0.0243,0.039 -0.10154,0.071 -0.17172,0.071 -0.0702,0 -0.22087,0.046 -0.33487,0.1034 -0.11401,0.057 -0.33873,0.1244 -0.49939,0.1501 l -0.29211,0.047 0.0325,-0.2215 z m 0.83725,-0.2929 c 0.0243,-0.039 0.10648,-0.071 0.18268,-0.071 0.0762,0 0.13857,-0.032 0.13857,-0.071 0,-0.039 0.0482,-0.071 0.10708,-0.071 0.0589,0 0.10708,-0.048 0.10708,-0.1065 0,-0.1314 -0.28157,-0.4646 -0.39263,-0.4646 -0.11106,0 -0.39263,0.3332 -0.39263,0.4646 0,0.059 -0.0321,0.1065 -0.0714,0.1065 -0.0393,0 -0.0714,0.064 -0.0714,0.1428 0,0.1038 0.0476,0.1428 0.17426,0.1428 0.0958,0 0.19411,-0.032 0.21837,-0.071 z m 9.7914796,-0.4796 c 0.56959,-0.044 0.51279,0.02 0.6796,-0.7697001 0.10998,-0.5207 0.15529,-2.1091 0.0628,-2.2016 -0.0416,-0.042 -0.0756,-0.1661 -0.0756,-0.2766 0,-0.1106 -0.0399,-0.329 -0.0888,-0.4855 l -0.0888,-0.2844 -0.54608,0 c -0.62148,0 -0.64971,0.026 -0.55725,0.5046 0.11336,0.5873 0.075,1.9136 -0.0772,2.6663 -0.15299,0.7568001 -0.13618,1.0112001 0.0617,0.9332001 0.0652,-0.026 0.34848,-0.064 0.62959,-0.086 z M 6.1529444,9.9283079 c 0.15705,-0.042 0.48897,-0.1306 0.73759,-0.1971 0.4275,-0.1144 0.48566,-0.1141 1.07082,0.01 0.34032,0.07 0.81151,0.1273 1.04709,0.1279 0.50257,0.001 1.3830896,-0.1952 1.5309896,-0.3415 0.10718,-0.1061 0.23238,-0.8318 0.23976,-1.3898 0.005,-0.3722 -0.0687,-0.9074 -0.18342,-1.3327 -0.0786,-0.2915 -0.0876,-0.2983 -0.44116,-0.3348 -0.5742096,-0.059 -0.8963196,-0.1281 -0.8963196,-0.1915 0,-0.032 -0.0723,-0.082 -0.16062,-0.1096 -0.0883,-0.028 -0.36468,-0.1746 -0.61409,-0.326 -0.24941,-0.1514 -0.48231,-0.2753 -0.51756,-0.2753 -0.0352,0 -0.0641,-0.032 -0.0641,-0.071 0,-0.1875 -0.27918,-0.03 -0.65538,0.3706 -0.37178,0.3956 -0.41543,0.474 -0.41543,0.7454 0,0.1668 -0.0321,0.3232 -0.0714,0.3474 -0.0393,0.024 -0.0714,0.1069 -0.0714,0.1837 0,0.1551 -0.11414,0.3784 -0.30339,0.5936 -0.0687,0.078 -0.12493,0.1681 -0.12493,0.1999 0,0.1 0.34485,0.063 0.75135,-0.079 0.38822,-0.1364 0.39085,-0.1364 0.39085,0 0,0.078 -0.0993,0.2321 -0.22063,0.3429 l -0.22062,0.2015 -1.10194,0 c -0.7526,0 -1.12849,0.023 -1.18571,0.08 -0.0461,0.046 -0.17371,0.084 -0.28365,0.084 -0.10994,0 -0.19989,0.032 -0.19989,0.071 0,0.039 -0.0642,0.071 -0.14277,0.071 -0.0785,0 -0.14278,0.027 -0.14278,0.059 0,0.033 -0.0779,0.101 -0.17302,0.152 -0.18219,0.098 -0.28332,0.3465 -0.21403,0.5271 0.0461,0.1201 0.52553,0.3324 0.75054,0.3324 0.0805,0 0.19232,-0.046 0.24841,-0.1019 0.1151,-0.1151 0.14054,-0.6833 0.0306,-0.6833 -0.0393,0 -0.0714,-0.064 -0.0714,-0.1428 0,-0.1852 0.0407,-0.18 0.25311,0.033 0.12743,0.1274 0.17522,0.2528 0.17522,0.4598 0,0.1565 -0.0321,0.3044 -0.0714,0.3287 -0.13127,0.081 -0.0734,0.2215 0.12493,0.3028 0.22116,0.091 0.76798,0.071 1.19574,-0.043 z m -3.49888,-1.0793 c 0.20573,-0.3259 0.22956,-0.6039 0.0658,-0.7677 -0.0966,-0.097 -0.12355,-0.099 -0.1804,-0.013 -0.0368,0.055 -0.0861,0.1892 -0.10953,0.2971 -0.0235,0.108 -0.0656,0.1964 -0.0937,0.1964 -0.0642,0 -0.2167,0.3289 -0.2167,0.4673 0,0.063 0.0699,0.1038 0.17757,0.1038 0.12939,0 0.22625,-0.077 0.35694,-0.2842 z m 0.48514,0.048 c 0.26307,-0.271 0.4081,-0.5016 0.4081,-0.6489 0,-0.056 0.0241,-0.1128 0.0535,-0.1259 0.0294,-0.013 0.13385,-0.1992 0.23201,-0.4135 0.0982,-0.2144 0.31499,-0.5268 0.48186,-0.6942 0.16687,-0.1674 0.3034,-0.321 0.3034,-0.3412 0,-0.068 0.24679,-0.3411 1.08866,-1.2037 0.46134,-0.4727 0.8388,-0.888 0.8388,-0.9229 0,-0.1533 -0.39705,-0.4103 -0.63371,-0.4103 -0.16776,0 -0.63626,0.2586 -0.80241,0.443 -0.0635,0.071 -0.14859,0.1281 -0.18909,0.1281 -0.0405,0 -0.23766,0.1606 -0.43816,0.3569 -0.20049,0.1963 -0.3832,0.3569 -0.40602,0.3569 -0.0846,0 -0.78643,0.7789 -0.8785,0.9749 -0.0525,0.1117 -0.12374,0.2588 -0.15842,0.327 -0.0347,0.068 -0.0631,0.1726 -0.0631,0.232 0,0.059 -0.0321,0.1081 -0.0714,0.1081 -0.0393,0 -0.0714,0.094 -0.0714,0.2082 0,0.1145 -0.0388,0.2211 -0.0862,0.2369 -0.0576,0.019 -0.0357,0.083 0.0658,0.1919 0.22734,0.2441 0.34549,0.5655 0.24483,0.6662 -0.0449,0.045 -0.0817,0.1537 -0.0817,0.2417 0,0.088 -0.0321,0.1798 -0.0714,0.2041 -0.0732,0.045 -0.10182,0.3212 -0.0333,0.3212 0.0209,0 0.1414,-0.1064 0.2677,-0.2365 z m 2.72831,-1.0663 c 0.13638,-0.088 0.24836,-0.2008 0.24885,-0.2499 4.8e-4,-0.049 0.033,-0.089 0.0723,-0.089 0.0393,0 0.0714,-0.064 0.0714,-0.1428 0,-0.079 0.0321,-0.1427 0.0714,-0.1427 0.0393,0 0.0714,-0.08 0.0714,-0.1785 0,-0.2216 -0.0932,-0.2288 -0.23214,-0.018 -0.0582,0.088 -0.26617,0.3284 -0.4622,0.5335 -0.19602,0.2051 -0.3395,0.3899 -0.31884,0.4105 0.0753,0.075 0.23533,0.034 0.4779,-0.123 z" />
                            </svg>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg> --}}
                        </x-slot>
                        <x-slot name="title">
                            Assinaturas
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                    <x-layout.side-bar-nav-link url="logs" active="*logs*" access_page="logs">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">
                            Logs
                        </x-slot>
                    </x-layout.side-bar-nav-link>
                </div>
            </div>
            <x-layout.side-bar-nav-link url="versions" active="*versoes*" access_page="versions">
                <x-slot name="svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                </x-slot>
                <x-slot name="title">
                    Versões
                </x-slot>
            </x-layout.side-bar-nav-link>
            @if (request()->userAgent() && str_contains(request()->userAgent(), 'Mobile'))
                <x-layout.side-bar-nav-link url="aplicativo" active="*aplicativo*" access_page="">
                    <x-slot name="svg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 3V4.4C10 4.96005 10 5.24008 10.109 5.45399C10.2049 5.64215 10.3578 5.79513 10.546 5.89101C10.7599 6 11.0399 6 11.6 6H12.4C12.9601 6 13.2401 6 13.454 5.89101C13.6422 5.79513 13.7951 5.64215 13.891 5.45399C14 5.24008 14 4.96005 14 4.4V3M9.2 21H14.8C15.9201 21 16.4802 21 16.908 20.782C17.2843 20.5903 17.5903 20.2843 17.782 19.908C18 19.4802 18 18.9201 18 17.8V6.2C18 5.0799 18 4.51984 17.782 4.09202C17.5903 3.71569 17.2843 3.40973 16.908 3.21799C16.4802 3 15.9201 3 14.8 3H9.2C8.0799 3 7.51984 3 7.09202 3.21799C6.71569 3.40973 6.40973 3.71569 6.21799 4.09202C6 4.51984 6 5.07989 6 6.2V17.8C6 18.9201 6 19.4802 6.21799 19.908C6.40973 20.2843 6.71569 20.5903 7.09202 20.782C7.51984 21 8.07989 21 9.2 21Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </x-slot>
                    <x-slot name="title">
                        App
                    </x-slot>
                </x-layout.side-bar-nav-link>
            @endif
        </nav>

    </div>
</div>
