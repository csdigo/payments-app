<?php


namespace App\Repositories;

use App\Models\Cobranca;

class CobrancaRepository
{
    protected $entity;

    public function __construct(Cobranca $cobranca)
    {
        $this->entity = $cobranca;
    }

    public function getAll()
    {
        return $this->entity->all();
    }
    public function getBy(int $DebtId): Cobranca|null
    {
        $obj = collect($this->entity::where("debtId", '=', $DebtId)->get())->first();
        return $obj;
    }

    public function insert(Cobranca $cobrancas)
    {
        return $this->entity->create($cobrancas->toArray());
    }

    public function update(Cobranca $cobranca)
    {
        Cobranca::where('id', $cobranca->id)
            ->update([
                'paid' => $cobranca->paid,
                'paidAt' => $cobranca->paidAt,
                'paidAmount' => $cobranca->paidAmount,
                'paidBy' => $cobranca->paidBy,
            ]);
    }
}