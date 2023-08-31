<?php

namespace App\Observers;

use App\Enums\PurchaseRequestStatus;
use App\Models\PurchaseRequest;
use App\Providers\EmailService;
use Symfony\Component\Mailer\Exception\TransportException;

class PurchaseRequestObserver
{
    public function __construct(private EmailService $emailService)
    {
    }

    /**
     * Handle the PurchaseRequest "created" event.
     */
    public function created(PurchaseRequest $purchaseRequest): void
    {
        $this->sendEmail($purchaseRequest);
    }

    /**
     * Handle the PurchaseRequest "updated" event.
     */
    public function updated(PurchaseRequest $purchaseRequest): void
    {
        $isDelete = $purchaseRequest->wasChanged('deleted_at') && $purchaseRequest->deleted_at !== null;
        $statusWasChanged = $purchaseRequest->wasChanged('status');
        $suppliesUserWasChanged = $purchaseRequest->wasChanged('supplies_user_id');

        if (!$isDelete) {
            if ($statusWasChanged) {
                $this->sendEmail($purchaseRequest);
            }

            if ($suppliesUserWasChanged) {
                $this->emailService->sendResponsibleAssignedEmail($purchaseRequest);
            }
        }
    }

    private function sendEmail(PurchaseRequest $purchaseRequest)
    {
        $isAllowedToSendEmail = true;
        $status = $purchaseRequest->status?->value;

        if ($status && $isAllowedToSendEmail) {
            $isPendingStatus = $status === PurchaseRequestStatus::PENDENTE->value;
            $isDraft = $status === PurchaseRequestStatus::RASCUNHO->value;

            try {
                if (!$isDraft && !$isPendingStatus) {
                    $this->emailService->sendStatusUpdatedEmail($purchaseRequest);
                }
            } catch (TransportException $transportException) {
                // Tratar erro de envio de email aqui, se necessário.
            }
        }
    }
}
