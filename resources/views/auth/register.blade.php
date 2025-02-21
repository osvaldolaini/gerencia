<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nome -->
            <div>
                <x-label for="name" value="{{ __('User Name') }}" />
                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

            <!-- Seletor de CPF ou CNPJ -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input id="cpf_radio" class="mr-2" type="radio" name="document_type" value="cpf" checked />
                    <x-label for="cpf_radio" value="{{ __('CPF') }}" class="mr-4" />

                    <x-input id="cnpj_radio" class="mr-2" type="radio" name="document_type" value="cnpj" />
                    <x-label for="cnpj_radio" value="{{ __('CNPJ') }}" />
                </div>
            </div>

            <!-- Campo para CPF ou CNPJ com Máscara -->
            <div class="mt-4">
                <x-label for="cpf_cnpj" />
                <x-input id="cpf_cnpj" class="block w-full mt-1" type="text" name="cpf_cnpj" :value="old('cpf_cnpj')"
                    required autocomplete="cpf_cnpj" />
            </div>

            <!-- Senha -->
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirmação de Senha -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block w-full mt-1" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <!-- Termos de Serviço -->
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <!-- Botão de Registro -->
            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <!-- Script para alternar entre CPF e CNPJ com máscaras -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfRadio = document.getElementById('cpf_radio');
            const cnpjRadio = document.getElementById('cnpj_radio');
            const cpfCnpjInput = document.getElementById('cpf_cnpj');

            function applyMask() {
                if (cpfRadio.checked) {
                    VMasker(cpfCnpjInput).unMask();
                    VMasker(cpfCnpjInput).maskPattern('999.999.999-99');
                } else if (cnpjRadio.checked) {
                    VMasker(cpfCnpjInput).unMask();
                    VMasker(cpfCnpjInput).maskPattern('99.999.999/9999-99');
                }
            }

            // Aplicar máscara inicial
            applyMask();

            // Alterar máscara ao selecionar CPF ou CNPJ
            cpfRadio.addEventListener('change', applyMask);
            cnpjRadio.addEventListener('change', applyMask);
        });
    </script>
</x-guest-layout>
