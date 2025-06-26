<span class="col-span-full sm:col-span-2">
    <div
        class="relative h-32 overflow-hidden text-gray-100 bg-gray-800 rounded-lg shadow-md dark:text-gray-800 dark:bg-gray-100">
        <div class="p-4 ">
            <dl>
                <dt class="text-sm font-medium leading-5 truncate">
                    Painel disciplina {{ date('Y') }}

                </dt>
                <dd class="mt-1 font-bold text-md">
                    <div class="grid w-full grid-cols-3 space-x-2">
                        <div class="flex items-center">
                            <span class="mx-auto badge badge-error">
                                {{ $fo->where('fact_type', 'negativo')->count() }} FO-
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="mx-auto badge badge-info">
                                {{ $fo->where('fact_type', 'positivo')->count() }} FO+
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="mx-auto badge badge-success ">
                                {{ $fo->where('fact_type', 'informativo')->count() }} FO!
                            </span>
                        </div>
                    </div>
                    <div class="grid w-full grid-cols-3">
                        <span class="flex flex-col items-center justify-center ">
                            FAFD
                            <span class="flex text-center badge badge-neutral">
                                {{ $fafd->count() }}
                            </span>
                        </span>
                        <span class="flex flex-col items-center justify-center text-center">
                            Em aberto
                            <span class="flex text-center badge badge-warning">
                                {{ $fafd->where('active', 1)->where('decision', '!=', 'fo')->where('decision', '!=', 'justificado')->where('supplement_number', null)->count() }}
                            </span>
                        </span>
                        <span class="flex flex-col items-center justify-center text-center">
                            Atrasado
                            <span class="flex text-center badge badge-error">
                                {{ $fafd->where('delivered_date', '>', date('Y-m-d'))->count() }}
                            </span>
                        </span>
                    </div>
                </dd>

            </dl>
        </div>
    </div>
</span>
