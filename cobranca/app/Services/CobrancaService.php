<?php

namespace App\Services;

use App\Repositories\CobrancaRepository;

class CobrancaService
{
    protected $repository;

    public function __construct(CobrancaRepository $cobrancaRepository)
    {
        $this->repository = $cobrancaRepository;
    }

    public function getCobrancas()
    {
        return $this->repository->getAll();
    }
}