<div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
    <!-- Faltas por artigo -->
    <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
        <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32" version="1.1"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Icon-Set-Filled" fill="currentColor">
                    <path
                        d="M533,153 L533,170.3 L548.947,175.084 C549.568,173.543 550,171.688 550,169.571 C550,160.419 541.453,153 533,153 L533,153 Z M531,156 C524.029,156.728 518,163.026 518,170.5 C518,178.508 524.492,185 532.5,185 C538.397,185 543.463,181.474 545.729,176.418 L531,172 L531,156 L531,156 Z" />
                </g>
            </svg>
            Faltas por artigo
        </h2>

        <div class="w-full p-4 bg-white shadow dark:bg-gray-800 rounded-2xl">

            <div x-data="{
                labels: @js($labels),
                data: @js($data)
            }" x-init="const isDarkMode = document.body.classList.contains('dark');
            new Chart($refs.chart, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ocorrências',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: isDarkMode ? '#fff' : '#000'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: isDarkMode ? '#fff' : '#000',
                                stepSize: 1,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: isDarkMode ? '#fff' : '#000'
                            }
                        }
                    }
                }
            });">
                <canvas x-ref="chart"></canvas>
            </div>
        </div>
    </div>
</div>
