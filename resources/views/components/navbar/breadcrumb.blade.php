<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{route('home')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{route('users')}}">Usuários</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{url('/users')}}#content">Lista de usuários</a>
            @if ($path === 'register')<i class="fa fa-angle-right"></i>@endif
        </li>
        @if ($path === 'register')
            <li>
                <a href="{{route('register')}}">Registra usuário</a>
            </li>
        @endif
        
    </ul>
    <div class="close-bread">
        <a href="#">
            <i class="fa fa-times"></i>
        </a>
    </div>
</div>