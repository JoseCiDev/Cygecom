<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: #f7f7f7">
        @foreach ($items as $index => $item)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if (!$loop->last)
                    <a style="color: #c49f51" data-cy="breadcrumb-{{$index}}" href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                @else
                    {{ $item['label'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
