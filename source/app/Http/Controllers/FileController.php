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
        try {

            $csvValid = collect($request->valid());

            if ($csvValid->count()) {
                return response()->json([
                    "error" => 'validation_error',
                    "message" => $csvValid,
                ], 422);
            }

            $payments = ImportPaymentsData::fromRequest($request);
            $this->paymentService->ImportPayments($payments);
            return response(null, 201);

        } catch (Throwable $e) { {
                return response($e, 400);
            }

        }
    }
}