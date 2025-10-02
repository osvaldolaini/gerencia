<div>
    @php
        use App\Enums\FunctionsObserver;
        use App\Enums\Penalty;
        use App\Enums\Rank;
        use Carbon\Carbon;
    @endphp

    <div class="py-4 rounded-2xl dark:bg-gray-700 ">

        <div class="flex justify-between mx-2 space-x-2 text-gray-600 lg:mx-1">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }} <br>
                {{-- <span class="badge badge-ghost {{ $al_sex == 'M' ? 'text-blue-500' : 'text-red-500' }}"> Al
                    {{ $al_nick }} ({{ $al_number }})
                </span> --}}
            </h3>
            <div>
                @livewire('discipline.fault-disciplines.fault-discipline-link', [$id])
            </div>
        </div>
    </div>
    <form>
        <x-layout.tabs>
            <x-slot name="nav">
                <x-layout.button-back route="{{ $back }}"></x-layout.button-back>
                <x-layout.tabs-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
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
                    </x-slot>
                    <x-slot name="title">Dados aluno</x-slot>
                </x-layout.tabs-nav>
                <x-layout.tabs-nav tab="tab2">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                    <x-slot name="title">Descrição</x-slot>
                </x-layout.tabs-nav>
                <x-layout.tabs-nav tab="tab3">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                    <x-slot name="title">Enquadramentos</x-slot>
                </x-layout.tabs-nav>
                <x-layout.tabs-nav tab="tab4">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                    <x-slot name="title">Justificativa</x-slot>
                </x-layout.tabs-nav>

                <x-layout.tabs-nav tab="tab5">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                    <x-slot name="title">Solução</x-slot>
                </x-layout.tabs-nav>
                <x-layout.tabs-nav tab="tab6">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
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
                    <x-slot name="title">Publicação</x-slot>
                </x-layout.tabs-nav>


            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full sm:col-span-2">
                                <div class="py-2 text-center ">
                                    @if ($student_id)
                                        @if ($students->logo_path)
                                            <img src="{{ url('storage/student/' . $students->id . '/' . $students->code_image . '_big.png') }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif

                                </div>
                            </div>
                            <div class="col-span-full sm:col-span-4">
                                <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-3">
                                    <div class="col-span-full sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                            for="title">
                                            Nome completo</label>
                                        <input type="text" wire:model="al_name" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('al_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-full sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                            for="title">
                                            Nome aluno</label>
                                        <input type="text" wire:model="al_nick" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('al_nick')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-full sm:col-span-2 ">
                                        <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                            for="title">
                                            Nº aluno</label>
                                        <input type="text" readonly wire:model="al_number" minlength="5"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('al_number')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-full sm:col-span-1 ">
                                        <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                            for="title">
                                            Turma</label>
                                        <input type="text" wire:model="al_class" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('al_class')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-full sm:col-span-3 ">
                                        <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                            for="title">
                                            Cia</label>
                                        <input type="text" wire:model="cia" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('cia')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab2" x-show="activeTab === '#tab2'">
                    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                        <div class="col-span-full">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Observador
                            </label>
                            @livewire('peoples.input-search', ['id' => $fact_observer_id])
                        </div>
                        <div class="col-span-full sm:col-span-1 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Tipo do FO</label>
                            <select wire:model="fact_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">Selecione...</option>
                                <option value="negativo">FO-</option>
                                <option value="positivo">FO+</option>
                                <option value="informativo">FO info</option>
                            </select>
                            @error('fact_type')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-2 ">
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
                        <div class="col-span-full sm:col-span-1 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Data</label>
                            <input type="date" wire:model="fact_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('fact_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-1 ">
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
                {{-- Enquadramento --}}
                <div id="tab3" x-show="activeTab === '#tab3'">
                    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Reincidente?
                            </label>
                            <x-layout.toggle-true-false id="repeat"
                                active="{{ $repeat }}"></x-layout.toggle-true-false>

                            @error('repeat')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div wire:ignore class="flex flex-col items-end justify-end col-span-full sm:col-span-5">
                            <div class="grid grid-cols-2 space-x-2">
                                <div class="col-span-1">
                                    {{-- <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Histórico
                                    </label> --}}
                                    @livewire('students.student-history', ['student' => $student_id])
                                </div>
                                {{-- <div class="col-span-1">

                                    @livewire('students.history.pdf', ['student' => $student_id])
                                </div> --}}
                            </div>


                        </div>

                        @if ($repeat == 1)
                            <div class="col-span-full sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Nº de vezes</label>
                                <input type="number" wire:model.live="repeat_number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('repeat_number')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    @livewire('discipline.fault-disciplines.settings.faults-select', [$faults])

                    @livewire('discipline.fault-disciplines.settings.mitigating-select', [$mitigating])
                    <div>
                        @if ($old_faults->count() > 0)
                            <span class="text-red-500">*Não é sua primeira falta</span>
                        @endif
                    </div>
                    @livewire('discipline.fault-disciplines.settings.aggravating-select', [$aggravating])
                    <div>
                        @if (!empty($relatedFaults))
                            <span class="text-red-500">*Já cometeu a(s) falta(s) nº
                                (
                                @foreach ($relatedFaults as $fault)
                                    <span>{{ $fault }},</span>
                                @endforeach
                                )
                            </span>
                        @endif
                        @if ($students->rank)
                            <span class="text-red-500"> **Aluno
                                {{ Rank::fromDb($students->rank->posto_grad)?->label() ?? 'Patente' }}
                            </span>
                        @endif
                    </div>
                </div>
                <div id="tab4" x-show="activeTab === '#tab4'">
                    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                        <div class="col-span-full sm:col-span-2 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Prazo para entregue (3 dias úteis)</label>
                            <input type="date" wire:model="delivered_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('delivered_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-2 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Devolução da justificativa</label>
                            <input type="date" wire:model="justification_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('justification_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @livewire('discipline.fault-disciplines.fault-discipline-justification', [$id])
                </div>

                <div id="tab5" x-show="activeTab === '#tab5'">
                    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                        <div class="col-span-full sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Decisão
                            </label>
                            <div class="p-0 tooltip tooltip-top" data-tip="Justificado" wire:click='modalJustify()'>
                                <label
                                    class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                    rounded-md cursor-pointer
                                    {{ 'justificado' == $decision ? 'bg-red-500 text-white' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                                    <input type="radio" value="justificado" class="hidden peer"
                                        {{ 'justificado' == $decision ? 'checked' : '' }}>

                                    <span class="text-xs">
                                        Justificado
                                    </span>
                                </label>
                            </div>
                            @foreach (Penalty::permitidos() as $item)
                                <div class="p-0 tooltip tooltip-top" data-tip="{{ $item->label() }}">
                                    <label
                                        class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                        rounded-md cursor-pointer
                                        {{ $item->value == $decision ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                                        <input type="radio" wire:model.live="decision" value="{{ $item->value }}"
                                            class="hidden peer" {{ $item->value == $decision ? 'checked' : '' }}>

                                        <span class="text-xs">
                                            {{ $item->label() }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Data solução</label>
                            <input type="date" wire:model.live="solution_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('solution_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($days)
                            <div class="col-span-full sm:col-span-1 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Quantidade de Dias</label>
                                <input type="number" wire:model.live="dacision_days" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('dacision_days')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-span-full sm:col-span-1 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Grau da punição</label>
                            <input type="number" wire:model.live="grau" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        @if ($decision == 'retirada_cm')
                            <div class="col-span-full sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Primeira retirada?
                                </label>
                                <x-layout.toggle-true-false id="first"
                                    active="{{ $first }}"></x-layout.toggle-true-false>
                                @error('first')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-span-full sm:col-span-full ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Solução <span wire:click="sugestionText()"
                                    class="mb-1 cursor-pointer badge badge-info">
                                    Sugestão de solução
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        fill="none">
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M10 3a7 7 0 100 14 7 7 0 000-14zm-9 7a9 9 0 1118 0 9 9 0 01-18 0zm10.01 4a1 1 0 01-1 1H10a1 1 0 110-2h.01a1 1 0 011 1zM11 6a1 1 0 10-2 0v5a1 1 0 102 0V6z" />
                                    </svg>
                                </span>
                            </label>
                            <textarea wire:model.live="solution" rows="5"
                                class="text-justify bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{!! $sugestion !!}</textarea>
                            @error('solution')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($solution_date && $decision)
                            <div class="col-span-full">
                                @livewire('discipline.fault-disciplines.fault-discipline-solution', [$id])
                            </div>
                        @endif
                    </div>

                </div>
                <div id="tab6" x-show="activeTab === '#tab6'">
                    <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Nota p/Bol Nr</label>
                            <input type="number" wire:model="supplement_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('supplement_number')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                BI Nr</label>
                            <input type="number" wire:model="bi_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('bi_number')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Data publicação</label>
                            <input type="date" wire:model="bi_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('bi_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Data SINCOMIL</label>
                            <input type="date" wire:model="sincomil_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('sincomil_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full ">
                            <div class="mockup-code">
                                <code>
                                    {{ $note }}
                                </code>
                            </div>
                        </div>
                        @if ($solution_date && $decision)
                            <div class="col-span-full">
                                @livewire('discipline.fault-disciplines.fault-discipline-note', [$id])
                            </div>
                        @endif

                    </div>

                </div>
            </x-slot>
        </x-layout.tabs>
    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button>
        <button type="submit" wire:click="save_out"
            class="text-white
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Salvar e sair
        </button>
    </div>
    {{-- MODAL SEND MAIL --}}
    <x-confirmation-modal wire:model="seeModalJustify">
        <x-slot name="title">
            FAFD justificada
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">A FAFD foi realmente considerada justificada?</h2>
            <p>O FO que gerou o formulário será excluído.</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('seeModalJustify')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="justify()" wire:loading.attr="disabled">
                Enviar
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <div>
        @section('scripts')
            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('openPdfInNew', ({
                        pdfPath
                    }) => {
                        window.open(pdfPath, '_blank');
                    })
                })
            </script>
        @endsection
    </div>

</div>
