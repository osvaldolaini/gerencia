<span class="col-span-full sm:col-span-2">
    <div
        class="relative h-32 overflow-hidden text-gray-100 bg-gray-800 rounded-lg shadow-md dark:text-gray-800 dark:bg-gray-100">
        <div class="p-4 ">
            <dl>
                <dt class="text-sm font-medium leading-5 text-white truncate">
                    Painel disciplina {{ date('Y') }}
                </dt>
                <dd class="mt-1 font-bold text-white text-md">
                    <div class="flex justify-around ">
                        <span class="flex items-center text-center badge badge-error">
                            {{ $fo->where('fact_type', 'negativo')->count() }} FO-
                        </span>
                        <span class="flex items-center text-center badge badge-info">
                            {{ $fo->where('fact_type', 'positivo')->count() }} FO+
                        </span>
                        <span class="flex items-center text-center badge badge-success ">
                            {{ $fo->where('fact_type', 'informativo')->count() }} FO!
                        </span>
                    </div>
                    <div class="flex justify-around">
                        <span class="flex flex-col items-center justify-start ">
                            FAFD
                            <span class="flex text-center badge badge-neutral">
                                {{ $fafd->count() }}
                            </span>
                        </span>
                        <span class="flex flex-col items-center justify-start text-center">
                            Em aberto
                            <span class="flex text-center badge badge-warning">
                                {{ $fafd->where('bi_number', null)->count() }}
                            </span>
                        </span>
                        <span class="flex flex-col items-center justify-start text-center">
                            Atrasado
                            <span class="flex text-center badge badge-error">
                                {{ $fafd->where('justification_date', null)->count() }}
                            </span>
                        </span>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</span>
