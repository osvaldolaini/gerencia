<div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
    <div class="w-full h-full px-1">
        <div class="flex flex-col h-full px-4 py-2 rounded-2xl">
            <div x-data='{
                    data: @json($data),
                    labels: @json($labels)
                }'
                x-init="const chartData = data;
                const chartLabels = labels;
                console.log(data);
                new Chart($refs.third, {
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
                <canvas id="third" x-ref="third"></canvas>
            </div>
        </div>
    </div>


</div>
