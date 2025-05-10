<div class="col-span-full ">
    <form>
        <div class="block">
            <div class="p-6 ">
                <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                    <div class="col-span-2 ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                            Linhas</label>
                        <input type="number" wire:model="rows" required minlength="1" maxlength="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('rows')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2 ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                            Colunas</label>
                        <input type="number" wire:model="columns" required minlength="1" maxlength="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('columns')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2 ">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                            Lado da porta
                        </label>
                        <select wire:model="door_side"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Selecione...</option>
                            <option value="right">Direita</option>
                            <option value="left">Esquerda</option>
                        </select>
                        @error('door_side')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="update"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Gerar / Alterar
        </button>
    </div>
</div>
