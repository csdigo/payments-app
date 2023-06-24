<?php

namespace App\Http\Controllers;

use App\Dto\PaymentData;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\CobrancaService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    private $service;

    public function __construct(CobrancaService $cobrancaService)
    {
        $this->service = $cobrancaService;

    }
    public function Payment(UpdatePaymentRequest $request)
    {
        try {
            $dto = PaymentData::fromRequest($request);
            $this->service->Payment($dto);
            return response(null, 201);
        } catch (Throwable $e) {
            return response($e, 500);
        }

    }
}