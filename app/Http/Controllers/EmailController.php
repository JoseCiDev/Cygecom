<?php

namespace App\Http\Controllers;

use App\Contracts\EmailControllerInterface;
use App\Mail\GenericEmail;
use App\Providers\UserService;
use Illuminate\Http\{RedirectResponse, Request};

class EmailController extends Controller implements EmailControllerInterface
{
    public function store(Request $request): RedirectResponse
    {
        $recipients = $request->input('recipients');
        $subject = $request->input('subject');
        $body = $request->input('body');

        try {
            $email = new GenericEmail($subject, $body, $recipients);
            $email->sendMail();
            session()->flash('success', "E-mail enviado!");

            return redirect('/email');
        } catch (\Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível enviar o e-mail.', $error->getMessage()]);
        }
    }

    public function index(UserService $userService)
    {
        $users = $userService->getUsers();

        return view('mails.sender', ['users' => $users]);
    }
}
