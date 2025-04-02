<div>
    <div role="tabpanel"
        class="p-6 mt-5 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
            <div class="col-span-full ">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                    Alunos
                </label>
                @livewire('discipline.input-search', ['class_id' => $class_id])
            </div>
            <div class="rounded-md col-span-full ">
                <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-4 sm:gap-3 sm:mb-5">
                    @foreach ($selectedStudents as $key => $value)
                        <div role="alert" class="w-full col-span-2 shadow-xl alert ">
                            <figure>
                                <img src="{{ url('storage/student/' . $value['id'] . '/' . $value['code_image'] . '_list.png') }}"
                                    class="mx-auto rounded ">
                            </figure>
                            <div>
                                <h3 class="font-bold">Al. {{ $value['nick'] }}</h3>
                                <div class="text-xs">T. {{ $value['class'] }}</div>
                            </div>
                            <span wire:click="removeStudents({{ $key }})"
                                class="btn btn-sm {{ $value['sex'] == 'F' ? 'btn-secondary' : 'btn-info' }}">Excluir
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="inline-block w-4 h-4 cursor-pointer stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
