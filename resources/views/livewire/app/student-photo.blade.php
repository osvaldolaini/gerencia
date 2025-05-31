<div class="max-w-md p-4 mx-auto bg-white rounded shadow">
    @if (session()->has('success'))
        <div class="p-2 mb-3 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="mb-3">
            <label class="block mb-1 font-semibold">Nome</label>
            <input type="text" wire:model="nome" class="w-full p-2 border rounded">
            @error('nome')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-semibold">Foto (use a câmera)</label>
            <input type="file" wire:model="foto" accept="image/*" capture="environment" class="w-full">
            @error('foto')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            @if ($foto)
                <img src="{{ $foto->temporaryUrl() }}" class="max-w-full mt-3 rounded shadow" alt="Preview">
            @endif
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Cadastrar</button>
    </form>
</div>
