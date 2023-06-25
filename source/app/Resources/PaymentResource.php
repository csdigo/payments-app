<?php

namespace App\Resources;

class PaymentResource
{
    public static $DUE_DATE_LESS_CURRENT_DATE = "Due date cannot be less than current date";
    public static $AMOUNT_DUE_LESS_EQUAL_ZERO = "Amount due cannot be less than or equal to 0";
    public static $PAID = "Paid";
    public static $NOT_FOUND = "Not Found";
    public static $IMPORT_EXISTS = "Payment already exists";

    

}