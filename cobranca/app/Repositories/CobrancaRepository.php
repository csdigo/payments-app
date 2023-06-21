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

    public function insert(array $cobrancas)
    {
        return $this->entity->create($cobrancas);
    }

    // TODO criar o demais com a demanda

}