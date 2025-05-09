<div>
    @props(['tab' => null])
    <a href="#{{ $tab }}" wire:click='resetAll'
        :class="activeTab === '#{{ $tab }}' ?
            'flex flex-col active items-center text-gray-600 dark:text-white' :
            'flex flex-col items-center text-gray-600 dark:text-white'"
        role="tab" id="{{ $tab }}-tab"
        @if ($tab) @click="activeTab = '#{{ $tab }}'" @endif
        class="flex items-center text-sm font-medium transition duration-75">
        {{ $svg }}
        <span class="px-1 transition duration-75 ">
            {{ $title }}
        </span>
    </a>
</div>
