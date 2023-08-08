<div class="user">
    <div class="dropdown">
        <a href="#" class='dropdown-toggle' data-toggle="dropdown" data-cy="profile-dropdown">
            <img src="{{ asset('img/demo/default-user.png') }}" alt="" width="30">
            {{ auth()->user()->person->name }}
        </a>
        <ul class="dropdown-menu pull-right">
            <li>
                <a data-cy="route-profile" href="{{ route('profile') }}">Configurações da conta</a>
            </li>
            <li>
                <a data-cy="btn-logout" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                     {{ __('Sair') }}
                 </a>
             <form id="logout-form" data-cy="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>
</div>
