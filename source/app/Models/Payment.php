<?php

namespace App\Models;

use App\Resources\PaymentResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\DateTime;

class Payment extends Model
{
    public function New($debtId, $name, $governmentId, $email, $debtAmount, $debtDueDate): array|null
    {
        $this->debtId = $debtId;
        $this->name = $name;
        $this->governmentId = $governmentId;
        $this->email = $email;
        $this->debtAmount = $debtAmount;
        $this->debtDueDate = $debtDueDate;
        $this->GenerateBarCode();

        $validation = [];
        $currentDate = Carbon::now(); // TODO GET ONLY DATE

        // TODO Ajustar lógica de data
        //$auxdebtDueDate = date('dd-mm-yyyy', strtotime($debtDueDate));
        $auxdebtDueDate = Carbon::parse($debtDueDate);
        if ($auxdebtDueDate < $currentDate)
            $validation[] = PaymentResource::$DUE_DATE_LESS_CURRENT_DATE;

        if ($debtAmount <= 0)
            $validation[] = PaymentResource::$AMOUNT_DUE_LESS_EQUAL_ZERO;

        return $validation;
    }

    public function Pay($paidAt, $paidAmount, $paidBy): array|null
    {
        $validation = [];
        if ($this->paid)
            $validation[] = PaymentResource::$PAID;

        $this->paidAt = $paidAt;
        $this->paid = true;
        $this->paidAmount = $paidAmount;
        $this->paidBy = $paidBy;
        $this->updateAt = Carbon::now();

        return $validation;
    }

    private function GenerateBarCode()
    {
        $this->barCode = str_pad($this->debtId, 44, "9", STR_PAD_LEFT);
    }

    protected $fillable = ['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtId', 'paidAt', 'paidAmount', 'paidBy', 'barCode'];
}