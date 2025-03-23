<div>
    <div class="grid grid-cols-2 join">
        @if ($previous)
            <a class="join-item btn btn-outline dark:btn-info"
                href="{{ route('fact-observed-edit', $previous->id) }}">Anterior</a>
        @endif

        @if ($next)
            <a class="join-item btn btn-outline dark:btn-info"
                href="{{ route('fact-observed-edit', $next->id) }}">Próximo</a>
        @endif
    </div>
</div>
