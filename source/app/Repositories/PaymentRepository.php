<?php


namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    protected $entity;

    public function __construct(Payment $cobranca)
    {
        $this->entity = $cobranca;
    }

    public function getAll()
    {
        return $this->entity->all();
    }
    public function getBy(int $DebtId): Payment|null
    {
        $obj = collect($this->entity::where("debtId", '=', $DebtId)->get())->first();
        return $obj;
    }

    public function insert(Payment $obj)
    {
        return $this->entity->create($obj->toArray());
    }

    public function update(Payment $obj)
    {
        Payment::where('id', $obj->id)
            ->update([
                'paid' => $obj->paid,
                'paidAt' => $obj->paidAt,
                'paidAmount' => $obj->paidAmount,
                'paidBy' => $obj->paidBy,
            ]);
    }
}