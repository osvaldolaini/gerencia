<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div x-cloak x-data="{ activeTab: window.location.hash ? window.location.hash : '#tab1' }" class="m-0">
    <!-- Tabs Content -->
    <div class="mb-5">
        {{ $content }}
    </div>
    <!-- Tabs Navigation -->
    <div class="flex max-w-full px-2 overflow-x-auto border-gray-200 gap-x-1 dark:border-white/10 dark:bg-gray-800">
        {{ $nav }}
    </div>
</div>
