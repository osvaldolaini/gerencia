<div class="w-full h-full px-1">
    <div class="flex flex-col h-full px-4 py-2 rounded-2xl">
        <div x-data='{
            labels: @json($chartLabels),
            datasets: @json($chartDatasets)
        }'
            x-init="new Chart($refs.faultsChart, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets.map((set, index) => ({
                        ...set,
                        backgroundColor: [
                            '#f87171', // vermelha
                            '#60a5fa', // azul
                            '#34d399', // verde
                            '#fbbf24', // amarela
                            '#a78bfa' // roxa
                        ][index % 5],
                        borderWidth: 1
                    }))
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                color: document.body.classList.contains('dark') ? '#fff' : '#000'
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            ticks: {
                                color: document.body.classList.contains('dark') ? '#fff' : '#000'
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            ticks: {
                                color: document.body.classList.contains('dark') ? '#fff' : '#000'
                            }
                        }
                    }
                }
            });">
            <canvas x-ref="faultsChart"></canvas>
        </div>
    </div>
</div>
