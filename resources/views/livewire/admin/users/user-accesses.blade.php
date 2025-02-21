<div id="accesses_checkbox">
    <x-user-accesses-section title="Todos" description="Acesso a todos os formulários">
        <div class="col-span-full lg:col-span-3">
            <ul
                class="grid items-center w-full grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <x-link-checkbox-new :access="$inputAccess" page="all" title="Todos">
                    <svg class="w-6 h-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 2A1.5 1.5 0 004 3.5V4h12v-.5A1.5 1.5 0 0014.5 2h-9zM2 7.5A1.5 1.5 0 013.5 6h13A1.5 1.5 0 0118 7.5V8H2v-.5zm-1 4A1.5 1.5 0 012.5 10h15a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 011 18.5v-7z"
                            fill="currentColor" />
                    </svg>
                </x-link-checkbox-new>
            </ul>
        </div>
    </x-user-accesses-section>
    <x-user-accesses-section title="Cadastros" description="Cadastros gerais (Usuários, aeronaves, etc)">
        <div class="col-span-full lg:col-span-3">
            <ul
                class="grid items-center w-full grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg col-span-full lg:col-span-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white ">
                <x-link-checkbox-new :access="$inputAccess" page="users" title="Lista de usuários">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-link-checkbox-new>
            </ul>
        </div>
    </x-user-accesses-section>
    <x-user-accesses-section title="Configurações" description="Configurações gerais do sistema">
        <div class="col-span-full lg:col-span-3">
            <ul
                class="grid items-center w-full grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg col-span-full lg:col-span-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white ">
                <x-link-checkbox-new :access="$inputAccess" page="settings" title="Configurações">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M1 3.5A1.5 1.5 0 012.5 2h15A1.5 1.5 0 0119 3.5v2A1.5 1.5 0 0117.5 7h-15A1.5 1.5 0 011 5.5v-2zm3.5 1a1 1 0 11-2 0 1 1 0 012 0zM1 9.5A1.5 1.5 0 012.5 8h6.073a1.5 1.5 0 011.342 2.17l-1 2a1.5 1.5 0 01-1.342.83H2.5A1.5 1.5 0 011 11.5v-2zm3.5 1a1 1 0 11-2 0 1 1 0 012 0zM1 15.5A1.5 1.5 0 012.5 14h5.27a1.5 1.5 0 011.471 1.206l.4 2A1.5 1.5 0 018.171 19H2.5A1.5 1.5 0 011 17.5v-2zm3.5 1a1 1 0 11-2 0 1 1 0 012 0zM12.159 13.059l-.682-.429a.987.987 0 01-.452-.611.946.946 0 01.134-.742.983.983 0 01.639-.425 1.023 1.023 0 01.758.15l.682.427c.369-.31.8-.54 1.267-.676V9.97c0-.258.104-.504.291-.686.187-.182.44-.284.704-.284.264 0 .517.102.704.284a.957.957 0 01.291.686v.783c.472.138.903.37 1.267.676l.682-.429a1.02 1.02 0 01.735-.107c.25.058.467.208.606.419.14.21.19.465.141.71a.97.97 0 01-.403.608l-.682.429a3.296 3.296 0 010 1.882l.682.43a.987.987 0 01.452.611.946.946 0 01-.134.742.982.982 0 01-.639.425 1.02 1.02 0 01-.758-.15l-.682-.428c-.369.31-.8.54-1.267.676v.783a.957.957 0 01-.291.686A1.01 1.01 0 0115.5 19a1.01 1.01 0 01-.704-.284.957.957 0 01-.291-.686v-.783a3.503 3.503 0 01-1.267-.676l-.682.429a1.02 1.02 0 01-.75.132.999.999 0 01-.627-.421.949.949 0 01-.135-.73.97.97 0 01.434-.61l.68-.43a3.296 3.296 0 010-1.882zm3.341-.507c-.82 0-1.487.65-1.487 1.449s.667 1.448 1.487 1.448c.82 0 1.487-.65 1.487-1.448 0-.8-.667-1.45-1.487-1.45z" />
                    </svg>
                </x-link-checkbox-new>
                <x-link-checkbox-new :access="$inputAccess" page="logs" title="Logs">
                    <svg class="w-6 h-6" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M168.8 32.89l-32.6 32.53 21.3 21.17L190 54.08zm33.9 33.96l-9.9 9.91 123 123.04 9.9-9.9zm159.4 18.06c-3.7 0-7.4.1-10.9.3-31.9 1.78-56.7 11.76-78.3 26.39l65.5 65.6c3.5 7.3 52 96.2 65.5 123.3-9.7-6.4-123.4-65.4-123.4-65.4l-15.3-15.2v140.3c23.9-14.6 50.1-27.7 83.6-31.2 37.5-4 83.5 4.3 144.2 33.1V118.7c-51.7-22.99-93.3-32.89-127.2-33.69-1.3 0-2.5-.11-3.7-.1zm-230.8 1.03C100.4 88.93 63.44 99 19.05 118.7v243.4C79.85 333.3 125.8 325 163.3 329c33 5.2 58.1 15.8 83.6 31.2V201.6c-38.6-38.5-77.1-77.1-115.6-115.66zm48.8 3.55l-9.9 9.89 123 123.02 9.9-9.9zM336 205.1l-27.5 27.5 55.1 27.6zM143.8 346.7c-32 .3-71.85 9.8-124.75 36v42.5c60.8-28.8 106.75-37.1 144.25-33.1 18.6 2 34.9 6.9 49.8 13.3-4.7 6.1-9.3 13.3-13.9 21.7h117.2c-6-8.2-11.8-15.4-17.7-21.6 15-6.5 31.4-11.4 50.1-13.4 37.5-4 83.5 4.3 144.2 33.1v-42.5c-53.1-26.3-93.1-35.9-125.2-36h-3.1c-4.8.1-9.4.4-13.9.9-34 3.6-59.6 18-85.6 34.4-5.7-.8-13-1.8-18.3-.9-27.2-16.2-58.2-30.4-85.5-33.5-5.6-.6-11.5-.9-17.6-.9z" />
                    </svg>
                </x-link-checkbox-new>
            </ul>
        </div>
    </x-user-accesses-section>

    <script>
        document.addEventListener('livewire:init', () => {
            setTimeout(() => {
                // let checkboxes = document.querySelectorAll('#accesses_checkbox input[type="checkbox"]');
                let checkboxes = document.querySelectorAll('#accesses_checkbox .custom-checkbox');
                let values = [];
                checkboxes.forEach(function(checkbox) {
                    // values.push(checkbox.values);
                    values.push(checkbox.getAttribute('data-value'));
                });
                Livewire.dispatch('updateCheckbox', {
                    checkboxs: values
                });
                console.log(values);
            }, 500);
        });
    </script>
</div>
