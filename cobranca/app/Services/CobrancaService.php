<?php

namespace App\Services;

use App\Dto\PaymentData;
use App\Http\Requests\UpdatePayment;
use App\Models\Cobranca;
use App\Repositories\CobrancaRepository;

class CobrancaService
{
    protected $repository;
    protected $mailService;

    public function __construct(CobrancaRepository $cobrancaRepository, MailService $mailService)
    {
        $this->repository = $cobrancaRepository;
        $this->mailService = $mailService;
    }

    public function getCobrancas()
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
                $cob = new Cobranca();
                $cob->New(
                    $payment->debtId,
                    $payment->name,
                    $payment->governmentId,
                    $payment->email,
                    $payment->debtAmount,
                    $payment->debtDueDate,
                );
                $resultImport[] = $this->repository->insert($cob)->toArray();

                $this->mailService->Send("Invoice available", $cob->email, "TEMPLATE_EMAIL");
            } else {
                $resultNotImport[] = $obj->toArray();
            }

            return [
                //'Success' => collect($resultImport)->count() + " rows imported",
               // 'Not Success' => collect($resultNotImport)->count() + " rows notimported",
            ];
        }
    }

    public function Payment(PaymentData $dto)
    {
        $obj = $this->repository->getBy($dto->debtId);
        if ($obj != null) {
            if (!$obj->Pay($dto->paidAt, $dto->paidAmount, $dto->paidBy)) {
                return false;
            }
            $this->repository->update($obj);
        }
        return true;
    }
}