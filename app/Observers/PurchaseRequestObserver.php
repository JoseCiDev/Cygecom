<?php

namespace App\Observers;

use App\Enums\{PurchaseRequestStatus, PurchaseRequestLogAction};
use App\Models\{PurchaseRequest, PurchaseRequestsLog};
use App\Providers\EmailService;
use Illuminate\Support\Facades\Auth;
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
        $this->createLog(PurchaseRequestLogAction::CREATE, $purchaseRequest);
    }

    /**
     * Handle the PurchaseRequest "updated" event.
     */
    public function updated(PurchaseRequest $purchaseRequest): void
    {
        $changes = [];

        $dirtyAttributes = $purchaseRequest->getDirty();

        $attributesToTrack = [
            'status' => $purchaseRequest->status->value,
            'supplies_user_id' => $purchaseRequest->supplies_user_id,
            'deleted_at' => $purchaseRequest->deleted_at,
        ];

        foreach ($attributesToTrack as $attribute => $value) {
            if (array_key_exists($attribute, $dirtyAttributes)) {
                $changes[$attribute] = $value;
            }
        }

        if (!empty($changes)) {
            $isDelete = $purchaseRequest->wasChanged('deleted_at') && $purchaseRequest->deleted_at !== null;

            if ($isDelete) {
                $this->createLog(PurchaseRequestLogAction::DELETE, $purchaseRequest, $changes);
            } else {
                $this->createLog(PurchaseRequestLogAction::UPDATE, $purchaseRequest, $changes);

                if (array_key_exists('status', $changes)) {
                    $this->sendEmail($purchaseRequest);
                }

                if (array_key_exists('supplies_user_id', $changes)) {
                    $this->emailService->sendResponsibleAssignedEmail($purchaseRequest);
                }
            }
        }
    }

    private function createLog(PurchaseRequestLogAction $action, $purchaseRequest, ?array $changes = null)
    {
        PurchaseRequestsLog::create([
            'purchase_request_id' => $purchaseRequest->id,
            'action' => $action->value,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }

    private function sendEmail(PurchaseRequest $purchaseRequest)
    {
        $isAllowedToSendEmail = true;
        $status = $purchaseRequest->status?->value;

        if ($status && $isAllowedToSendEmail) {
            $approver = $purchaseRequest->user->approver;
            $isPendingStatus = $status === PurchaseRequestStatus::PENDENTE->value;
            $isDraft = $status === PurchaseRequestStatus::RASCUNHO->value;

            try {
                if ($approver && $isPendingStatus) {
                    $this->emailService->sendPendingApprovalEmail($purchaseRequest, $approver);
                }

                if (!$isDraft && !$isPendingStatus) {
                    $this->emailService->sendStatusUpdatedEmail($purchaseRequest);
                }
            } catch (TransportException $transportException) {
                // Tratar erro de envio de email aqui, se necessário.
            }
        }
    }
}
