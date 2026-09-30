<div class="w-full h-full p-0 m-0 text-gray-900 rounded-b-md ">
    <!-- Faltas por ano escolar -->
    <div class="p-5 shadow-md bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100 rounded-2xl">
        <h2 class="flex items-center gap-2 mb-4 text-xl font-semibold ">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 32 32" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                    sketch:type="MSPage">
                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-518.000000, -153.000000)"
                        fill="currentColor">
                        <path
                            d="M533,153 L533,170.3 L548.947,175.084 C549.568,173.543 550,171.688 550,169.571 C550,160.419 541.453,153 533,153 L533,153 Z M531,156 C524.029,156.728 518,163.026 518,170.5 C518,178.508 524.492,185 532.5,185 C538.397,185 543.463,181.474 545.729,176.418 L531,172 L531,156 L531,156 Z"
                            id="pie-chart" sketch:type="MSShapeGroup">

                        </path>
                    </g>
                </g>
            </svg>
            Faltas por ano escolar
        </h2>
        <div class="w-full h-full px-1">
            <div class="flex flex-col h-full px-4 py-2 rounded-2xl">

                <div x-data='{
                        labels: @json($labels),
                        datasets: @json($data)
                    }'
                    x-init="new Chart($refs.faultsChart, {
                        type: 'bar',
                    
                        data: {
                            labels: labels,
                    
                            datasets: datasets.map((set, index) => ({
                                ...set,
                    
                                backgroundColor: [
                                    '#f87171',
                                    '#60a5fa',
                                    '#34d399',
                                    '#fbbf24',
                                    '#a78bfa'
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
                                        color: document.body.classList.contains('dark') ?
                                            '#fff' : '#000'
                                    }
                                }
                            },
                    
                            scales: {
                                x: {
                                    stacked: false,
                    
                                    ticks: {
                                        color: document.body.classList.contains('dark') ?
                                            '#fff' : '#000'
                                    }
                                },
                    
                                y: {
                                    stacked: false,
                                    beginAtZero: true,
                    
                                    ticks: {
                                        stepSize: 1,
                                        color: document.body.classList.contains('dark') ? '#fff' : '#000'
                                    },
                    
                                    grid: {
                                        drawTicks: true
                                    }
                                }
                            }
                        }
                    });">
                    <canvas x-ref="faultsChart"></canvas>
                </div>

            </div>
        </div>
        <div class="w-full">

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b border-base-300">
                            <th class="text-left px-3 py-2">
                                Série
                            </th>

                            @foreach ($data as $dataset)
                                <th class="text-center px-3 py-2">
                                    {{ $dataset['label'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labels as $index => $label)
                            <tr class="border-b border-base-200">
                                <td class="p-1 font-medium text-xs">
                                    {{ $label }}
                                </td>
                                @foreach ($data as $dataset)
                                    <td class="text-center px-3 py-2">
                                        {{ $dataset['data'][$index] ?? 0 }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





</div>
