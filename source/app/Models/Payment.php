<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function New($debtId, $name, $governmentId, $email, $debtAmount, $debtDueDate)
    {
        $this->debtId = $debtId;
        $this->name = $name;
        $this->governmentId = $governmentId;
        $this->email = $email;
        $this->debtAmount = $debtAmount;
        $this->debtDueDate = $debtDueDate;
    }

    public function Pay($paidAt, $paidAmount, $paidBy)
    {
        if ($this->paid) {
            return false; // Boleto já pago
        }
        $this->paidAt = $paidAt;
        $this->paid = true;
        $this->paidAmount = $paidAmount;
        $this->paidBy = $paidBy;
        $this->updateAt = Carbon::now();

        return true;
    }

    protected $fillable = ['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtId', 'paidAt', 'paidAmount', 'paidBy'];
}