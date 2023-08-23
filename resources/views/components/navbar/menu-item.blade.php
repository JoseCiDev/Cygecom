@props([
    'route',
    'title'
])
<li>
    <a data-cy="route-{{$route}}" href=" {{ route( $route ) }} ">
        <span> {{ $title }} </span>
    </a>
</li>