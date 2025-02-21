<x-form-section submit="generatePrivateKey">
    <x-slot name="title">
        {{ __('Generate Private Key') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Generate a pair of private and public keys to be used for digital signature and validation. The private key will be protected by this password. Use a strong password with at least 8 characters, containing at least 1 letter, 1 number, 1 special character and do not give it to anyone.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            @if ($user_key_created_at)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mr-2 size-6"> <!-- Adicione um espaço à direita com 'mr-2' -->
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                    <x-label value="{{ 'Chave' . ' ' }}" />
                    <x-label class="mx-1 text-green-500" value="{{ 'ATIVADA' }}" />
                    <x-label value="{{ 'criada em: ' . $user_key_created_at }}" />
                </div>
            @else
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mr-2 size-6"> <!-- Adicione um espaço à direita com 'mr-2' -->
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                    <x-label class="text-red-500"
                        value="{{ __('Você ainda não gerou as suas chaves para poder assinar.') }}" />
                </div>
            @endif
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="state.key_password" value="{{ __('Private Key Password') }}" />
            <x-input id="state.key_password" type="password" class="block w-full mt-1" wire:model="state.key_password"
                autocomplete="new-password" />
            <x-input-error for="state.key_password" class="mt-2" />
        </div>
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-label for="key_password_confirmation" value="{{ __('Confirm Private Key Password') }}" />
            <x-input id="key_password_confirmation" type="password" class="block w-full mt-1"
                wire:model="state.key_password_confirmation" autocomplete="new-password" />
            <x-input-error for="state.key_password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Keys generated and saved.') }}
        </x-action-message>

        <x-button wire:click.prevent="generatePrivateKey">
            {{ __('Generate Keys') }}
        </x-button>
    </x-slot>
</x-form-section>
