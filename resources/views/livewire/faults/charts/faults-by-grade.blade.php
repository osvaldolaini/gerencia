<div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">

    <!-- Faltas por ano escolar -->
    <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
        <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Lançamentos Recentes
        </h2>
        <div class="w-full h-full px-1">
            <div class="flex flex-col h-full px-4 py-2 rounded-2xl">
                <div x-data='{
                        data: @json($data),
                        labels: @json($labels)
                    }'
                    x-init="const chartData = data;
                    const chartLabels = labels;
                    new Chart($refs.faultsByGrade, {
                        type: 'pie',
                        data: {

                            datasets: [{
                                data: data,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            // Certifique-se de acessar os dados corretamente usando chartData e chartLabels
                                            const value = chartData[context.dataIndex] || 0;
                                            return value + '%';
                                        }
                                    }
                                }
                            }

                        },
                    });">
                    <canvas id="faultsByGrade" x-ref="faultsByGrade"></canvas>
                </div>
            </div>
        </div>
    </div>



</div>
