<div>
    @props(['active', 'access_page' => null])
    @if (in_array($access_page, auth()->user()->jsonAccesses) || in_array('all', auth()->user()->jsonAccesses))
        <!-- Dropdown Pool -->
        <div class="w-full -mt-1 dropdown dropdown-hover">
            <div tabindex="0" role="button"
                class="flex justify-between items-center p-2 my-1 w-full
            transition-colors duration-200
            {{ Request::is($active)
                ? 'hover:text-blue-900 dark:hover:text-blue-500 text-blue-500 dark:text-blue-300 bg-gray-100 border-r-8 border-blue-400 dark:border-blue-500 dark:bg-gray-600'
                : 'pr-4 text-gray-800 hover:text-gray-800 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-600 dark:text-gray-100' }}">
                <span class="flex justify-start">
                    {{ $svg }}
                    <span class="flex justify-start ml-2 mr-4 font-normal">
                        {{ $title }}
                    </span>
                </span>
                <svg class="flex justify-end w-3 h-3 ml-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </div>

            <div tabindex="0"
                class="z-[1] justify-start w-full -mt-1 bg-white divide-gray-100 rounded-b-lg shadow dropdown-content menu dark:bg-gray-700">
                {{ $content }}
            </div>
        </div>
    @endif
</div>
<!-- End Dropdown Pool -->
