<?php

namespace App\Http\Controllers;

use App\Services\CobrancaService;
use Illuminate\Http\Request;

class CobrancaController extends Controller
{
    // ENDPOINT de teste para validar consulta e conexão com o banco de dados

    protected $serviceCobranca;

    public function __construct(CobrancaService $cobrancaService)
    {
        $this->serviceCobranca = $cobrancaService;
    }

    public function getAll()
    {
        return response($this->serviceCobranca->getCobrancas(), 200);
    }
}