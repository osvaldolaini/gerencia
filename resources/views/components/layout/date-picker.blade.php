<div>
    @props(['field' => null])
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <div class="w-full">
        <fieldset
            class="flex w-full space-y-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <div class="flex justify-around w-full">
                <input autocomplete="off"
                    class="flex flex-1 p-2.5 text-left text-gray-900 border-none rounded-lg sm:text-sm rounded-l-md focus:ring-inset bg-gray-50 focus:ring-primary-600 dark:bg-gray-700 focus:border-none dark:placeholder-gray-400 dark:text-white"
                    wire:model="{{ $field }}" x-mask="99/99/9999" type="text" id="{{ $field }}"
                    placeholder="DD/MM/YYYY" />
                <span
                    class="flex px-3 py-1.5 text-right text-green-500 pointer-events-none sm:text-sm rounded-r-md dark:bg-gray-300">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>
            </div>
        </fieldset>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            var picker = new Pikaday({
                field: document.getElementById("{{ $field }}"),
                format: 'DD/MM/YYYY',
                toString(date, format) {
                    // Formatar o dia e o mês com dois dígitos
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();

                    return `${day}/${month}/${year}`;

                },
                parse(dateString, format) {
                    // dateString é o resultado do método `toString`
                    const parts = dateString.split('/');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);

                    return new Date(year, month, day);
                },
                i18n: {
                    previousMonth: 'Mês anterior',
                    nextMonth: 'Próximo mês',
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                        'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                    ],
                    weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira',
                        'Sexta-feira', 'Sábado'
                    ],
                    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
                },
                onSelect: function(date) {
                    // Converte a data para o formato desejado (DD/MM/YYYY)
                    const formattedDate = picker.toString(date, 'DD/MM/YYYY');

                    // Atualiza o campo de input
                    document.getElementById("{{ $field }}").value = formattedDate;

                    // Atualiza o modelo do Livewire manualmente
                    @this.set('{{ $field }}', formattedDate);
                }
            });
        });
    </script>
</div>
