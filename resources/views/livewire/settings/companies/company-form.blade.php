<div>
    <form>
        <x-layout.tabs>
            <x-slot name="nav">
                <x-layout.tabs-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </x-slot>
                    <x-slot name="title">{{ $breadcrumb }}</x-slot>
                </x-layout.tabs-nav>
                @if ($id)
                    <x-layout.tabs-nav tab="tab4">
                        <x-slot name="svg">
                            <svg fill="currentColor"
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                wire:xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 " version="1.1"
                                id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M174.545,302.545H81.455c-6.982,0-11.636,4.655-11.636,11.636s4.655,11.636,11.636,11.636h93.091
                               c6.982,0,11.636-4.655,11.636-11.636S181.527,302.545,174.545,302.545z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M139.636,244.364H46.545c-6.982,0-11.636,4.655-11.636,11.636s4.655,11.636,11.636,11.636h93.091
                               c6.982,0,11.636-4.655,11.636-11.636S146.618,244.364,139.636,244.364z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M104.727,186.182H11.636C4.655,186.182,0,190.836,0,197.818s4.655,11.636,11.636,11.636h93.091
                               c6.982,0,11.636-4.655,11.636-11.636S111.709,186.182,104.727,186.182z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M463.127,155.927c-3.491-4.655-11.636-5.818-16.291-2.327l-123.345,94.255c-12.8,9.309-30.255,9.309-43.055,0
                               L157.091,153.6c-4.655-3.491-12.8-3.491-16.291,2.327c-3.491,4.655-3.491,12.8,2.327,16.291l124.509,94.255
                               c10.473,8.145,23.273,11.636,34.909,11.636s25.6-3.491,34.909-11.636L460.8,172.218
                               C465.455,168.727,466.618,160.582,463.127,155.927z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M477.091,104.727H104.727c-6.982,0-11.636,4.655-11.636,11.636S97.745,128,104.727,128h372.364
                               c6.982,0,11.636,4.655,11.636,11.636v232.727c0,6.982-4.655,11.636-11.636,11.636H104.727c-6.982,0-11.636,4.655-11.636,11.636
                               c0,6.982,4.655,11.636,11.636,11.636h372.364c19.782,0,34.909-15.127,34.909-34.909V139.636
                               C512,119.855,496.873,104.727,477.091,104.727z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M461.964,340.945l-69.818-69.818c-4.655-4.655-11.636-4.655-16.291,0s-4.655,11.636,0,16.291l69.818,69.818
                               c2.327,2.327,5.818,3.491,8.145,3.491s5.818-1.164,8.146-3.491C466.618,352.582,466.618,345.6,461.964,340.945z" />
                                    </g>
                                </g>
                            </svg>

                        </x-slot>
                        <x-slot name="title">Dados disparo email</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab2">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6471 16.375L12.0958 14.9623C11.3351 14.2694 10.9547 13.923 10.5236 13.7918C10.1439 13.6762 9.73844 13.6762 9.35878 13.7918C8.92768 13.923 8.5473 14.2694 7.78652 14.9623L4.92039 17.5575M13.6471 16.375L13.963 16.0873C14.7238 15.3944 15.1042 15.048 15.5352 14.9168C15.9149 14.8012 16.3204 14.8012 16.7 14.9168C17.1311 15.048 17.5115 15.3944 18.2723 16.0873L19.4237 17.0896M13.6471 16.375L17.0469 19.4528M17 9C17 10.1046 16.1046 11 15 11C13.8954 11 13 10.1046 13 9C13 7.89543 13.8954 7 15 7C16.1046 7 17 7.89543 17 9ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Logo</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab3">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6471 16.375L12.0958 14.9623C11.3351 14.2694 10.9547 13.923 10.5236 13.7918C10.1439 13.6762 9.73844 13.6762 9.35878 13.7918C8.92768 13.923 8.5473 14.2694 7.78652 14.9623L4.92039 17.5575M13.6471 16.375L13.963 16.0873C14.7238 15.3944 15.1042 15.048 15.5352 14.9168C15.9149 14.8012 16.3204 14.8012 16.7 14.9168C17.1311 15.048 17.5115 15.3944 18.2723 16.0873L19.4237 17.0896M13.6471 16.375L17.0469 19.4528M17 9C17 10.1046 16.1046 11 15 11C13.8954 11 13 10.1046 13 9C13 7.89543 13.8954 7 15 7C16.1046 7 17 7.89543 17 9ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Assinatura</x-slot>
                    </x-layout.tabs-nav>
                @endif


                <x-layout.button-back route="{{ $back }}"></x-layout.button-back>
            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                                    Nome</label>
                                <input type="text" wire:model="name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Sigla</label>
                                <input type="text" wire:model="nick"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('nick')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="email">
                                    Email</label>
                                <input type="email" wire:model="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Carga horária (períodos)</label>
                                <input type="text" wire:model="workload" maxlength="4"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('workload')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-full">
                                <div class="col-span-full">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Comandante </label>
                                    @livewire('settings.companies.input-search', ['id' => $people_id])
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if ($id)
                    <div id="tab4" x-show="activeTab === '#tab4'">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">

                            <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">

                                <!-- HOST -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Host SMTP
                                    </label>

                                    <input type="text" wire:model="mail_host" placeholder="smtp.gmail.com"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_host')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- PORTA -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Porta SMTP
                                    </label>

                                    <input type="number" wire:model="mail_port" placeholder="587"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_port')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- USERNAME -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Usuário SMTP
                                    </label>

                                    <input type="text" wire:model="mail_username"
                                        placeholder="1ciaalunos@gmail.com"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_username')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- SENHA -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Senha SMTP
                                    </label>

                                    <input type="password" wire:model="mail_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- CRIPTOGRAFIA -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Criptografia
                                    </label>

                                    <select wire:model="mail_encryption"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                        <option value="">Selecione</option>
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                    </select>

                                    @error('mail_encryption')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- EMAIL REMETENTE -->
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Email Remetente
                                    </label>

                                    <input type="email" wire:model="mail_from_address"
                                        placeholder="1ciaalunos@cmpa.eb.mil.br"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_from_address')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- NOME REMETENTE -->
                                <div class="col-span-full sm:col-span-6">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Nome do Remetente
                                    </label>

                                    <input type="text" wire:model="mail_from_name" placeholder="1ª Cia CMPA"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                    @error('mail_from_name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="tab2" x-show="activeTab === '#tab2'">
                        @livewire('settings.companies.upload-image', [$id])
                    </div>
                    <div id="tab3" x-show="activeTab === '#tab3'">
                        @livewire('settings.companies.company-signature', [$id])
                    </div>
                @endif

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
</div>
