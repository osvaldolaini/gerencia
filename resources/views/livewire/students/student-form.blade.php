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
                        <x-slot name="title">Foto</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab3">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7 2C5.34315 2 4 3.34315 4 5V6H3C2.44772 6 2 6.44772 2 7C2 7.55228 2.44772 8 3 8H4V11H3C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H4V16H3C2.44772 16 2 16.4477 2 17C2 17.5523 2.44772 18 3 18H4V19C4 20.6569 5.34315 22 7 22H19C20.6569 22 22 20.6569 22 19V5C22 3.34315 20.6569 2 19 2H7ZM9 12C9 9.79086 10.7909 8 13 8C15.2091 8 17 9.79086 17 12C17 14.2091 15.2091 16 13 16C10.7909 16 9 14.2091 9 12ZM10.3373 19.6816C10.7235 19.2671 11.415 19 12.9909 19C14.606 19 15.2909 19.2611 15.6701 19.6753C16.0431 20.0826 16.6757 20.1105 17.083 19.7375C17.4903 19.3646 17.5182 18.732 17.1452 18.3247C16.1519 17.2398 14.683 17 12.9909 17C11.3097 17 9.8629 17.2568 8.87391 18.3184C8.49745 18.7225 8.51985 19.3552 8.92395 19.7317C9.32804 20.1081 9.96081 20.0857 10.3373 19.6816Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13 10C11.8954 10 11 10.8954 11 12C11 13.1046 11.8954 14 13 14C14.1046 14 15 13.1046 15 12C15 10.8954 14.1046 10 13 10Z"
                                    fill="currentColor" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Contatos</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab4">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.2715 18.2637L20.9996 20M11.5 19H6.2C5.0799 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2C3 7.0799 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H17.8C18.9201 5 19.4802 5 19.908 5.21799C20.2843 5.40973 20.5903 5.71569 20.782 6.09202C21 6.51984 21 7.0799 21 8.2V11M20.6067 8.26229L15.5499 11.6335C14.2669 12.4888 13.6254 12.9165 12.932 13.0827C12.3192 13.2295 11.6804 13.2295 11.0677 13.0827C10.3743 12.9165 9.73279 12.4888 8.44975 11.6335L3.14746 8.09863M20 16.5C20 17.8807 18.8807 19 17.5 19C16.1193 19 15 17.8807 15 16.5C15 15.1193 16.1193 14 17.5 14C18.8807 14 20 15.1193 20 16.5Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Emails </x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab5">
                        <x-slot name="svg">
                            <x-layout.svg.activities
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"></x-layout.svg.activities>
                        </x-slot>
                        <x-slot name="title">Atividades extras </x-slot>
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
                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Nome aluno</label>
                                <input type="text" wire:model="nick"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('nick')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-2 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Nº aluno</label>
                                <input type="text" wire:model="number" minlength="5"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('number')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-1 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="sex">
                                    Sexo</label>
                                <select wire:model="sex"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="Selecione">...</option>
                                    <option value="M">M</option>
                                    <option value="F">F</option>
                                </select>
                                @error('sex')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-2 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Matricula</label>
                                <input type="date" wire:model="entry_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('entry_date')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-2 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Grau ajustado</label>
                                <x-layout.input-value value="{{ $grau }}" field="grau"
                                    placeholder="Grau ajustado"></x-layout.input-value>
                                {{-- @error('grau')
                                    <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>
                    </div>
                </div>
                @if ($id)
                    <div id="tab2" x-show="activeTab === '#tab2'">
                        @livewire('students.upload-image', [$id])
                    </div>
                    <div id="tab3" x-show="activeTab === '#tab3'" wire:ignore>
                        @livewire('students.student-contact', [$id])
                    </div>
                    <div id="tab4" x-show="activeTab === '#tab4'" wire:ignore>
                        @livewire('students.student-emails', [$id])
                    </div>
                    <div id="tab5" x-show="activeTab === '#tab5'" wire:ignore>
                        @livewire('extracurriculas.student-activities.student-activity-list', [$id])
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
