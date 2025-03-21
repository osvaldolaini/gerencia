<div>
    <div class="grid grid-cols-2 join">
        @if ($previous)
            <a class="join-item btn btn-outline" href="{{ route('fault-discipline-edit', $previous->id) }}">Anterior</a>
        @endif

        @if ($next)
            <a class="join-item btn btn-outline" href="{{ route('fault-discipline-edit', $next->id) }}">Próximo</a>
        @endif
    </div>
</div>
