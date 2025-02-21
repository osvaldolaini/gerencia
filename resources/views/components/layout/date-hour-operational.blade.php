<div>
    @props(['field' => null])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div wire:ignore>
        <input type="time" id="datetimepicker-{{ $field }}" wire:model="{{ $field }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="Selecione a data e hora" />
    </div>
    <script>
        document.addEventListener('livewire:init', function() {
            // Inicializa o Flatpickr
            flatpickr("#datetimepicker-{{ $field }}", {
                enableTime: true, // Ativa o modo horário
                dateFormat: "d/m/Y H:i", // Formato da data e hora
                time_24hr: true, // Usa formato 24 horas
                onChange: function(selectedDates, dateStr) {
                    @this.dispatch('selectedDateTime', ['{{ $field }}', dateStr])
                },
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</div>
