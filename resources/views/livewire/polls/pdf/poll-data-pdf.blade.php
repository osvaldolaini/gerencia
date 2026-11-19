<div>
    <span wire:click='seeData()'
        class="flex text-black m-0 p-0.5 px-2 bg-accent 
                                                rounded-2xl cursor-pointer">
        Ver dados
        <x-layout.svg.pdf class="w-5 h-5"></x-layout.svg.pdf>
    </span>
    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfData', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection
</div>
