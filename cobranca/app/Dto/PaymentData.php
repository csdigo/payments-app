<?php

namespace App\Dto;


use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Traits\CsvParser;

class PaymentData
{
    public $debtId;
    public $paidAt;
    public $paidAmount;
    public $paidBy;

    public static function fromRequest(UpdatePaymentRequest $request): PaymentData
    {
        $data = $request->validated();
        $ret = new self();

        $ret->debtId = $data['debtId'];
        $ret->paidAt = $data['paidAt'];
        $ret->paidAmount = $data['paidAmount'];
        $ret->paidBy = $data['paidBy'];
        return $ret;
    }

    
}