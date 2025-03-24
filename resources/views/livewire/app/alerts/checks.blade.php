<div>
    <section class="py-2 mb-5 dark:bg-gray-100 dark:text-gray-900">
        <div class="container flex flex-col items-center justify-center p-4 mx-auto space-y-8 md:p-10 md:px-24 xl:px-48">
            <h1 class="text-5xl font-bold leading-none text-center">{{ $alertsUser->alert->title }}</h1>
            <p class="text-xl font-medium text-center">{{ $alertsUser->alert->description }}</p>
            <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:space-x-8">
                @if ($alertsUser->see == 0)
                    <button wire:click='check'
                        class="px-8 py-3 text-lg font-semibold rounded dark:bg-blue-600 dark:text-gray-50">
                        Marcar com lido
                    </button>
                @endif
            </div>
        </div>
    </section>
    {{-- <div role="alert" class="alert">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 stroke-info shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ $alertsUser->alert->title }}</span>
        <p>{{ $alertsUser->alert->description }}</p>
        <div>
            @if ($alertsUser->see)
                <button class="btn btn-sm" wire:click='check'>Deny</button>
            @else
                <button class="btn btn-sm btn-primary" wire:click='check'>Accept</button>
            @endif

        </div>
    </div> --}}
</div>
