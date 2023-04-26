@props([
    'route',
    'title'
])

<li>
    <a href=" {{ route( $route ) }} ">
        <span> {{ $title }} </span>
    </a>
</li>