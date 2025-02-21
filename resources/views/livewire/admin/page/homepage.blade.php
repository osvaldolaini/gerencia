<div>
    <div class="grid grid-cols-4 gap-2 w-full">
        @if ($partners)
            <a href="{{ route('partners') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Associados
                            </dt>
                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                {{ $partners }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($locations)
            <a href="{{ route('locations') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 20H6C3.79086 20 2 18.2091 2 16V7C2 4.79086 3.79086 3 6 3H17C19.2091 3 21 4.79086 21 7V10"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M15 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M2 8H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M18.5 15.6429L17 17.1429" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="17" cy="17" r="5" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Locações
                            </dt>
                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                {{ $locations }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($partnerLate)
            <a href="{{ route('partnersLate') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <style>
                                .a,
                                .b {
                                    fill: none;
                                    stroke-linecap: round;
                                    stroke-width: 1.5px;
                                }

                                .a {
                                    stroke-linejoin: round;
                                }

                                .b {
                                    stroke-linejoin: bevel;
                                }
                            </style>
                        </defs>
                        <path class="a" d="M3,21.016l.78984-2.87249C5.0964,13.3918,8.5482,10.984,12,10.984" />
                        <circle class="b" cx="12" cy="5.98404" r="5" />
                        <circle class="a" cx="17" cy="18" r="5" />
                        <circle class="a" cx="17" cy="18" r="0.20745" />
                        <circle class="a" cx="14.35106" cy="18" r="0.20745" />
                        <circle class="a" cx="19.47832" cy="18" r="0.20745" />
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Sócios em atraso
                            </dt>
                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                {{ $partnerLate }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($installmentLates)
            <a href="{{ route('installmentsLate') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6667 2H6.33333C6.02379 2 5.86902 2 5.73853 2.01198C4.28819 2.14511 3.1383 3.35155 3.01142 4.87321C3 5.01012 3 5.1725 3 5.49727V20.2598C3 21.1323 4.05871 21.5026 4.55769 20.8045C4.90385 20.3203 5.59615 20.3203 5.94231 20.8045L6.375 21.4098C6.9375 22.1967 8.0625 22.1967 8.625 21.4098C9.1875 20.623 10.3125 20.623 10.875 21.4098C11.4375 22.1967 12.5625 22.1967 13.125 21.4098C13.6875 20.623 14.8125 20.623 15.375 21.4098C15.9375 22.1967 17.0625 22.1967 17.625 21.4098L18.0577 20.8045C18.4038 20.3203 19.0962 20.3203 19.4423 20.8045C19.9413 21.5026 21 21.1323 21 20.2598V5.49727C21 5.1725 21 5.01012 20.9886 4.87321C20.8617 3.35155 19.7118 2.14511 18.2615 2.01198C18.131 2 17.9762 2 17.6667 2Z"
                            stroke="currentColor" stroke-width="1.5" />
                        <path d="M7.5 15.5H16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M14 8.00003L10 12M10 8.00002L14 12" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Parcelas em atraso
                            </dt>
                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                {{ $installmentLates }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($bill)
            <a href="{{ route('paidMonth') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.755 2H7.24502C6.08614 2 5.50671 2 5.03939 2.16261C4.15322 2.47096 3.45748 3.18719 3.15795 4.09946C3 4.58055 3 5.17705 3 6.37006V20.3742C3 21.2324 3.985 21.6878 4.6081 21.1176C4.97417 20.7826 5.52583 20.7826 5.8919 21.1176L6.375 21.5597C7.01659 22.1468 7.98341 22.1468 8.625 21.5597C9.26659 20.9726 10.2334 20.9726 10.875 21.5597C11.5166 22.1468 12.4834 22.1468 13.125 21.5597C13.7666 20.9726 14.7334 20.9726 15.375 21.5597C16.0166 22.1468 16.9834 22.1468 17.625 21.5597L18.1081 21.1176C18.4742 20.7826 19.0258 20.7826 19.3919 21.1176C20.015 21.6878 21 21.2324 21 20.3742V6.37006C21 5.17705 21 4.58055 20.842 4.09946C20.5425 3.18719 19.8468 2.47096 18.9606 2.16261C18.4933 2 17.9139 2 16.755 2Z"
                            stroke="currentColor" stroke-width="1.5" />
                        <path d="M9.5 10.4L10.9286 12L14.5 8" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.5 15.5H16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Contas pagas no mês
                            </dt>
                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                {{ $bill }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($cashier)
            <a href="{{ route('cashier') }}" class="col-span-full sm:col-span-1">
                <div class="relative overflow-hidden bg-blue-500 rounded-lg shadow-md h-32">
                    <svg class="absolute w-24 h-24 rounded-md opacity-50 -top-6 -right-6 md:-right-4 text-blue-800"
                        fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.52 491.52" xml:space="preserve">
                        <g>
                            <g>
                                <g>
                                    <rect x="81.92" y="184.32" width="122.88" height="143.36" />
                                    <rect x="245.76" y="163.84" width="40.96" height="40.96" />
                                    <rect x="307.2" y="163.84" width="40.96" height="40.96" />
                                    <rect x="368.64" y="163.84" width="40.96" height="40.96" />
                                    <rect x="245.76" y="225.28" width="40.96" height="40.96" />
                                    <rect x="307.2" y="225.28" width="40.96" height="40.96" />
                                    <rect x="368.64" y="225.28" width="40.96" height="40.96" />
                                    <rect x="245.76" y="286.72" width="40.96" height="40.96" />
                                    <rect x="307.2" y="286.72" width="40.96" height="40.96" />
                                    <rect x="368.64" y="286.72" width="40.96" height="40.96" />
                                    <path
                                        d="M471.04,102.4h-40.96V20.48C430.08,9.169,420.911,0,409.6,0H245.76c-11.311,0-20.48,9.169-20.48,20.48v81.92h-81.92
                                   V61.44h40.96V0H61.44v61.44h40.96v40.96H20.48C9.169,102.4,0,111.569,0,122.88v266.24c0,11.311,9.169,20.48,20.48,20.48h20.48
                                   v61.44c0,11.311,9.169,20.48,20.48,20.48h368.64c11.311,0,20.48-9.169,20.48-20.48V409.6h20.48c11.311,0,20.48-9.169,20.48-20.48
                                   V122.88C491.52,111.569,482.351,102.4,471.04,102.4z M409.6,450.56H81.92V409.6H409.6V450.56z M450.56,368.64h-20.48H61.44H40.96
                                   V143.36h204.8c11.311,0,20.48-9.169,20.48-20.48V40.96h122.88v81.92c0,11.311,9.169,20.48,20.48,20.48h40.96V368.64z" />
                                </g>
                            </g>
                        </g>
                    </svg>
                    <div class="p-4 ">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                Contas pagas no mês
                            </dt>
                            <dd class="mt-1 text-3xl font-bold leading-9 text-white">
                                {{ $cashier }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </a>
        @endif
        @if ($dailyreports)
            <div class="col-span-full sm:col-span-1">
                @livewire('admin.dashboard.daily-report')
            </div>
        @endif
        @if ($reports)
            <div class="col-span-full sm:col-span-2">
                @livewire('admin.dashboard.reports', ['full'])
            </div>
        @endif
        @if ($reportsTiny)
            <div class="col-span-full sm:col-span-2">
                @livewire('admin.dashboard.reports', ['tiny'])
            </div>
        @endif
        @if ($lastReceiveds)
            <div class="row-span-2 col-span-full sm:col-span-2 relative overflow-hidden bg-blue-500 text-white rounded-lg shadow-md w-full">
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center space-x-1">
                        <div class="-space-y-1">
                            <h2 class="text-sm font-semibold leadi">Últimos pagamentos</h2>
                        </div>
                    </div>
                    <span title="Open options">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M480 106.667c-117.82 0-213.333 95.512-213.333 213.333v1280c0 117.82 95.512 213.333 213.333 213.333h960c117.82 0 213.333-95.512 213.333-213.333V320c0-117.82-95.512-213.333-213.333-213.333H480ZM480 0h960c176.731 0 320 143.269 320 320v1280c0 176.731-143.269 320-320 320H480c-176.731 0-320-143.269-320-320V320C160 143.269 303.269 0 480 0Zm106.667 320C527.757 320 480 367.756 480 426.667v106.666C480 592.243 527.756 640 586.667 640h746.666c58.91 0 106.667-47.756 106.667-106.667V426.667c0-58.91-47.756-106.667-106.667-106.667H586.667Zm0-106.667h746.666c117.821 0 213.334 95.513 213.334 213.334v106.666c0 117.821-95.513 213.334-213.334 213.334H586.667c-117.821 0-213.334-95.513-213.334-213.334V426.667c0-117.821 95.513-213.334 213.334-213.334ZM480 853.333h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666C1072.243 853.333 1120 901.09 1120 960c0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1066.667 800 1018.91 800 960c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Zm-853.333 320h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1386.667 800 1338.91 800 1280c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Zm-853.333 320h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1706.667 800 1658.91 800 1600c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Z" />
                        </svg>
                    </span>
                </div>
                <div class="p-0 m-0 bg-white text-gray-900 w-full h-full rounded-b-md ">
                    <div class="w-full px-1">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-3 px-2">Cliente</th>
                                        <th class="py-3 px-2">Responsável</th>
                                        <th class="py-3 px-2 ">Valor</th>
                                        <th class="py-3 px-2">Recibo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lastReceiveds as $item)
                                        <tr class="border-b border-opacity-20 ">
                                            <td class="py-3 px-2">
                                                {{ $item->partners->name }}
                                            </td>
                                            <td class="py-3 px-2">
                                                {{ $item->created_by }}
                                            </td>
                                            <td class="py-3 px-2 text-center flex flex-nowrap">
                                                R$ {{ $item->value }}
                                            </td>
                                            <td class="py-3 px-2 text-center">
                                                @if ($item->active == 1)
                                                    @livewire('admin.financial.voucher', ['data' => $item, 'type' => 'received'], key($item->id))
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($accessesPool)
            <div class="row-span-2 col-span-full sm:col-span-2 relative overflow-hidden bg-blue-500 text-white rounded-lg shadow-md w-full">
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center space-x-1">
                        <div class="-space-y-1">
                            <h2 class="text-sm font-semibold leadi">Acessos à piscicna</h2>
                        </div>
                    </div>
                    <span title="Open options">
                        <svg class="w-5 h-5" viewBox="0 0 15 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.63639 1C4.14922 1 3 2.20269 3 3.72724V4H9V3.63639C9 1.56904 10.6333 0 12.6818 0V1C11.1667 1 10 2.14011 10 3.63639V10H9V9H3V12H2V3.72724C2 1.68816 3.55993 0 5.63639 0V1ZM3 8H9V5H3V8Z"
                                fill="currentColor" />
                            <path
                                d="M7.43931 13.4416C6.54499 13.9461 5.56317 14.5 3.95454 14.5C2.47163 14.5 1.34063 13.7381 0.625824 12.9317L1.37417 12.2683C1.95937 12.9286 2.83745 13.5 3.95454 13.5C5.29393 13.5 6.0834 13.0584 6.95888 12.5645L6.96977 12.5584C7.8641 12.0539 8.84591 11.5 10.4545 11.5C11.9851 11.5 13.3377 12.3202 14.3064 13.0716L13.6936 13.8618C12.7714 13.1465 11.6421 12.5 10.4545 12.5C9.11516 12.5 8.32568 12.9416 7.4502 13.4355L7.43931 13.4416Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
                <div class="p-0 m-0 bg-white text-gray-900 w-full h-full rounded-b-md ">
                    <div class="w-full px-1">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-3 px-2">Data</th>
                                        <th class="py-3 px-2">Hora</th>
                                        <th class="py-3 px-2 ">Cliente</th>
                                        <th class="py-3 px-2">Passe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($accessesPool) as $item)
                                        <tr class="border-b border-opacity-20 ">
                                            <td class="py-3 px-2">
                                                {{ $item->date }}
                                            </td>
                                            <td class="py-3 px-2">
                                                {{ $item->hour }}
                                            </td>
                                            <td class="py-3 px-2 text-center flex flex-nowrap">
                                                {{ $item->name }}
                                            </td>
                                            <td class="py-3 px-2 text-center">
                                                {{ $item->category }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        @endif


    </div>

</div>
