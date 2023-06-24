<?php

namespace App\Http\Controllers;

use App\Dto\ImportPaymentsData;
use App\Http\Requests\ImportPaymentsRequest;
use App\Services\PaymentService;

class FileController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function Upload(ImportPaymentsRequest $request)
    {
        $payments = ImportPaymentsData::fromRequest($request);
        $this->paymentService->ImportPayments($payments);
        return response(null, 201);
    }
}