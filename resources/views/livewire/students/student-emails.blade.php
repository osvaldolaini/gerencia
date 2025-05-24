<div>
    <div class="flex justify-center mb-5">
        <span wire:click="addRow"
            class="flex justify-between px-3 py-1 text-white transition-colors duration-200 bg-gray-700 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
            Enviar ficha indivídual <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 " viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 12H20M12 4V20" stroke="CurrentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Assunto</th>
                    <th>Para</th>
                    <th>Data</th>
                    <th>Enviado por</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emails as $email)
                    <tr>
                        <td>
                            {{ $email->subject }}
                        </td>
                        <td>
                            {{ $email->studentContact->parent }}
                            <br />
                            <span class="badge badge-ghost badge-sm">
                                <{{ $email->from }}>
                            </span>
                        </td>
                        <td>
                            {{ $email->created_at }}
                        </td>
                        <th>
                            {{ $email->created_by }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
