@props([
    'route',
    'title'
])

<li>
    <a href="{{ route ( $route ) }}" data-toggle="dropdown" class='dropdown-toggle'>
        <span>{{ $title }}</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href=""> --- </a>
        </li>
    </ul>
</li>

