<?php

namespace App\Providers;

use App\Mail\GenericEmail;
use Illuminate\Support\ServiceProvider;

class EmailService extends ServiceProvider
{
    public function sendPendingApprovalEmail($purchaseRequest, $approver)
    {
        $subject = "Solicitação de " . $purchaseRequest->type->label() . " nº " . $purchaseRequest->id . ' - Aprovação pendente';
        $message = "Olá, aprovador " . $purchaseRequest->user->approver->person->name . '! '
            . "A solicitação de " . $purchaseRequest->type->label() . " nº " . $purchaseRequest->id . " está pendente."
            . "Solicitante: " . $purchaseRequest->user->person->name . ". "
            . "E-mail do solicitante: " . $purchaseRequest->user->email . ". "
            . "Telefone/celular do solicitante: " . $purchaseRequest->user->person->phone->first()->number . ". "
            . "Atribuição de responsável: " . $purchaseRequest->suppliesUser->person->name . '. '
            . "E-mail do responsável: " . $purchaseRequest->suppliesUser->email . '. '
            . "Telefone/celular do responsável: " . $purchaseRequest->suppliesUser->person->phone->first()->number . '. ';

        $email = new GenericEmail($subject, $message, $approver->email);
        $email->sendMail();
    }

    public function sendStatusUpdatedEmail($purchaseRequest)
    {
        $subject = "Solicitação de " . $purchaseRequest->type->label() . " nº " . $purchaseRequest->id . ' - Status atualizado para ' . $purchaseRequest->status->label();
        $message = "Olá, " . $purchaseRequest->user->person->name . "! Sua solicitação de " . $purchaseRequest->type->label() . " teve o status atualizado para [" . $purchaseRequest->status->label() . '].';

        $email = new GenericEmail($subject, $message, $purchaseRequest->user->email);
        $email->sendMail();
    }

    public function sendResponsibleAssignedEmail($purchaseRequest)
    {
        $subject = "Solicitação de " . $purchaseRequest->type->label() . " nº " . $purchaseRequest->id . " - Atribuição de responsável";
        $message = "Olá, " . $purchaseRequest->user->person->name . "! "
            . "Sua solicitação de " . $purchaseRequest->type->label() . " nº " . $purchaseRequest->id . " foi atualizada. "
            . "Foi atribuído um responsável pelo processo.";

        $email = new GenericEmail($subject, $message, $purchaseRequest->user->email);
        $email->sendMail();
    }
}
