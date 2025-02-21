<div>
    @props(['access_page' => null])
    @if (in_array($access_page, auth()->user()->jsonAccesses) || in_array('all', auth()->user()->jsonAccesses))
        <p
            class="w-full pb-1 mb-0 ml-2 text-xs font-normal text-gray-900 border-b-2 border-gray-900 dark:text-blue-300 dark:border-blue-300">
            {{ $slot }}
        </p>
    @endif
</div>
