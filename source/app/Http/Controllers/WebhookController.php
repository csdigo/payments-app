<?php

namespace App\Http\Controllers;

use App\Dto\PaymentData;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebhookController extends Controller
{
    private $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;

    }
    public function Payment(UpdatePaymentRequest $request)
    {
        try {

            $dto = PaymentData::fromRequest($request);
            if ($this->service->Payment($dto) == []) {
                return response(null, 201);
            }
            return response(null, 404);
        } catch (Throwable $e) {
            return response($e, 500);
        }

    }
}