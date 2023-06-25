<?php

namespace App\Services;

use App\Dto\PaymentData;
use App\Models\Invoice;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Resources\EmailResource;
use App\Resources\PaymentResource;

class PaymentService
{
    protected $repository;
    protected $mailService;
    protected $bankService;

    public function __construct(PaymentRepository $repository, MailService $mailService, BankService $bankService)
    {
        $this->repository = $repository;
        $this->mailService = $mailService;
        $this->bankService = $bankService;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function ImportPayments(array $payments)
    {
        $resultImport = [];
        $resultNotImport = [];
        foreach ($payments as $payment) {
            $obj = $this->repository->getBy($payment->debtId);

            if ($obj == null) {
                $cob = new Payment();
                $resultValidation = $cob->New(
                    $payment->debtId,
                    $payment->name,
                    $payment->governmentId,
                    $payment->email,
                    $payment->debtAmount,
                    $payment->debtDueDate,
                );

                if ($resultValidation == [])
                    $resultImport[] = $this->PaymentSuccess($cob);
                else
                    $resultImport[] = $resultValidation;
            } else {
                // Boletos já importados
                $resultNotImport[] = $obj->toArray();
            }
        }
        return [
            //'Success' => collect($resultImport)->count() + " rows imported",
            // 'Not Success' => collect($resultNotImport)->count() + " rows notimported",
        ];
    }

    public function Payment(PaymentData $dto): array|null
    {
        $validation = [];
        $obj = $this->repository->getBy($dto->debtId);
        if ($obj != null) {
            $obj->Pay($dto->paidAt, $dto->paidAmount, $dto->paidBy); // idempotência
            if ($validation == []) {
                $this->repository->update($obj);
            }
        }
        else{
            $validation[] = PaymentResource::$NOT_FOUND;
        }
        return $validation;
    }

    private function PaymentSuccess($cob)
    {
        $pay = $this->repository->insert($cob);

        $invoiceAttachment = $this->bankService->Register($cob);

        $this->mailService->Send(
            EmailResource::$SUBJECT_INVOICE,
            $pay->email,
            EmailResource::$BODY_INVOICE,
            $invoiceAttachment
        );

        return $pay;
    }

}