<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Enums\PurchaseRequestStatus;
use App\Mail\GenericEmail;
use App\Models\PurchaseRequest;

class EmailService extends ServiceProvider
{
    /**
     * Envio de e-mail quando o status da solicitação é atualizado para o usuário que a criou
     * @param PurchaseRequest $purchaseRequest Solicitação de compra que teve o status atualizado
     * @return void
     */
    public function sendStatusUpdatedEmail(PurchaseRequest $purchaseRequest): void
    {
        $name = explode(' ', $purchaseRequest->user->person->name)[0];
        $requestType = strtolower($purchaseRequest->type->label());
        $requestStatus = strtolower($purchaseRequest->status->label());
        $id = $purchaseRequest->id;

        $requestName = $purchaseRequest[$purchaseRequest->type->value]?->name;

        $subject = "Solicitação de " . $requestType . " nº " . $id . ' - Status atualizado para ' . $requestStatus;

        $email = new GenericEmail($subject, $purchaseRequest->user->email, 'mails.status-updated', [
            'name' => $name,
            'requestType' => $requestType,
            'requestStatus' => $requestStatus,
            'reason' => $purchaseRequest->supplies_update_reason ?? false,
            'requestName' => $requestName,
        ]);

        $email->sendMail();
    }

    /**
     * Envio de e-mail quando um responsável é atribuído a solicitação
     * @param PurchaseRequest $purchaseRequest Solicitação de compra que teve o responsável atribuído
     * @return void
     */
    public function sendResponsibleAssignedEmail($purchaseRequest): void
    {
        $name = explode(' ', $purchaseRequest->user->person->name)[0];
        $requestType = strtolower($purchaseRequest->type->label());
        $requestStatus = strtolower($purchaseRequest->status->label());
        $id = $purchaseRequest->id;
        $suppliesUser = $purchaseRequest->suppliesUser->person->name;
        $suppliesUserMail = $purchaseRequest->suppliesUser->email;

        $requestName = $purchaseRequest[$purchaseRequest->type->value]?->name;

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
