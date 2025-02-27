<div>
    @foreach ($user->getGroupsOfUser() as $level)
        <div class="badge {{ $level->badgeClass() }} gap-2">
            <svg wire:click="remove('{{ $level->dbName() }}')" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" class="inline-block w-4 h-4 cursor-pointer stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ $level->label() }}
        </div>
    @endforeach
</div>
