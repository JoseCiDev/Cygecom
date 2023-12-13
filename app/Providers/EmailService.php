<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Enums\PurchaseRequestStatus;
use App\Mail\GenericEmail;
use App\Models\PurchaseRequest;

class EmailService extends ServiceProvider
{
    public function sendStatusUpdatedEmail(PurchaseRequest $purchaseRequest)
    {
        $name = explode(' ', $purchaseRequest->user->person->name)[0];
        $requestType = strtolower($purchaseRequest->type->label());
        $requestStatus = strtolower($purchaseRequest->status->label());
        $id = $purchaseRequest->id;

        $requestName = $purchaseRequest[$purchaseRequest->type->value]->name;

        $subject = "Solicitação de " . $requestType . " nº " . $id . ' - Status atualizado para ' . $requestStatus;

        $isCanceled = $purchaseRequest->status->value === PurchaseRequestStatus::CANCELADA->value;
        $email = new GenericEmail($subject, $purchaseRequest->user->email, 'mails.status-updated', [
            'name' => $name,
            'requestType' => $requestType,
            'requestStatus' => $requestStatus,
            'cancelReason' => $isCanceled ? $purchaseRequest->supplies_update_reason : false,
            'requestName' => $requestName,
        ]);

        $email->sendMail();
    }

    public function sendResponsibleAssignedEmail($purchaseRequest)
    {
        $name = explode(' ', $purchaseRequest->user->person->name)[0];
        $requestType = strtolower($purchaseRequest->type->label());
        $requestStatus = strtolower($purchaseRequest->status->label());
        $id = $purchaseRequest->id;
        $suppliesUser = $purchaseRequest->suppliesUser->person->name;
        $suppliesUserMail = $purchaseRequest->suppliesUser->email;

        $requestName = $purchaseRequest[$purchaseRequest->type->value]->name;

        $subject = "Solicitação de " . $requestType . " nº " . $id . " - Atribuição de responsável";

        $email = new GenericEmail($subject, $purchaseRequest->user->email, 'mails.responsible-assigned', [
            'name' => $name,
            'requestType' => $requestType,
            'requestStatus' => $requestStatus,
            'requestName' => $requestName,
            'suppliesUser' => $suppliesUser,
            'suppliesUserMail' => $suppliesUserMail,
        ]);

        $email->sendMail();
    }
}
