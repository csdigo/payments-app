<?php

namespace App\Http\Controllers;

use App\Dto\ImportPaymentsData;
use App\Http\Requests\ImportPaymentsRequest;
use App\Services\CobrancaService;

class FileController extends Controller
{
    private $cobrancaService;

    public function __construct(CobrancaService $cobrancaService)
    {
        $this->cobrancaService = $cobrancaService;
    }

    public function Upload(ImportPaymentsRequest $request)
    {
        $payments = ImportPaymentsData::fromRequest($request);
        $this->cobrancaService->ImportPayments($payments);
        return response(null, 200);
    }
}