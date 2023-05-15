<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateUpdate extends Component
{
    public $action;

    public $user;
    public function __construct(string $action, array $user = null)
    {
        $this->action = $action;
        $this->user   = $user;
    }

    public function render(): View|Closure|string
    {
        $user           = $this->user;
        $person         = $user['person'];
        $profile        = $user['profile'];
        $address        = $person['address'];
        $phone          = $person['phone'];
        $identification = $person['identification'];

        return view('form.user.create-update', [
            'user'           => $user,
            'person'         => $person,
            'profile'        => $profile,
            'address'        => $address,
            'phone'          => $phone,
            'identification' => $identification,
        ]);
    }
}
