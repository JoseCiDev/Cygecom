@props([
    'action',
    'method',
])


<form action="{{route('profile', ['updateAction' => 'address'])}}" method="{{ $method }}" class='form-vertical'>

</form>