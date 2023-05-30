<div class="user">
    {{ $slot }}
    <div class="dropdown">
        <a href="#" class='dropdown-toggle' data-toggle="dropdown">
            <img src="{{ asset('img/demo/default-user.png') }}" alt="" width="30">
            {{ auth()->user()->person->name }}
        </a>
        <ul class="dropdown-menu pull-right">
            <li>
                <a href="{{ route('profile') }}">Configurações da conta</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                     {{ __('Sair') }}
                 </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>
</div>
