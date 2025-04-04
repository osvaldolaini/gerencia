<div class="min-h-screen pb-40 ">
    @php
        use App\Enums\MilitaryRank;
        use App\Enums\FunctionsObserver;
    @endphp
    <div class="flex justify-between md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Profile Information') }}</h3>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update your account\'s profile information and email address.') }}
            </p>
        </div>

    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div
            class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <form>
                <div class="grid grid-cols-6 gap-6">

                    <!-- Profile Photo -->
                    @livewire('admin.users.user-upload-image', ['id' => $user->id])
                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <label for="password"class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Senha</label>
                        <input type="password" wire:model="password" placeholder="Senha"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <label for="email"class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email</label>
                        <input type="email" wire:model="email" placeholder="Email"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nome guerra -->
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="name">
                            Nome</label>
                        <input type="text" wire:model="name"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="nick">
                            Nome guerra</label>
                        <input type="text" wire:model="nick"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        @error('nick')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="posto_grad">
                            Posto / Graduação</label>
                        <select wire:model="posto_grad"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Selecione...</option>
                            @foreach (MilitaryRank::cases() as $item)
                                <option value="{{ $item->value }}">{{ $item->label() }}</option>
                            @endforeach
                        </select>
                        @error('posto_grad')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-span-6 sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="sex">
                            Sexo</label>
                        <select wire:model="sex"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="Selecione">...</option>
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                        @error('sex')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="function">
                            Função</label>
                        <select wire:model="function"
                            class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Selecione...</option>
                            @foreach (FunctionsObserver::cases() as $item)
                                <option value="{{ $item->value }}">{{ $item->label() }}</option>
                            @endforeach
                        </select>
                        @error('function')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <span wire:click='save()'
                            class='inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'>
                            Salvar
                        </span>
                    </div>


                </div>
            </form>
        </div>
    </div>

</div>
