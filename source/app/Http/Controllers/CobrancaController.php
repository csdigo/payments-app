<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class CobrancaController extends Controller
{
    // ENDPOINT de teste para validar consulta e conexão com o banco de dados

    protected $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function getAll()
    {
        return response($this->service->getAll(), 200);
    }
}