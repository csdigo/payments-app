<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtId'];
}