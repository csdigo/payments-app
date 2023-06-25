<?php

namespace Tests\Unit;

use App\Models\Payment;
use App\Resources\PaymentResource;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_correct(): void
    {
        $payment = new Payment();

        $validation = $payment->New(
            1,
            "Rodrigo Muniz",
            "111111",
            "muniz@company.com",
            100.50,
            Carbon::now()->addDays(3),
        );

        $this->assertEquals($validation, []);
    }

    public function test_validation_amount_zero(): void
    {
        $payment = new Payment();

        $validation = $payment->New(
            1,
            "Rodrigo Muniz",
            "111111",
            "muniz@company.com",
            0,
            Carbon::now()->addDays(3),
        );
        $bool = in_array(PaymentResource::$AMOUNT_DUE_LESS_EQUAL_ZERO, $validation);

        $this->assertTrue($bool);
    }

    public function test_validation_amount_negative(): void
    {
        $payment = new Payment();

        $validation = $payment->New(
            1,
            "Rodrigo Muniz",
            "111111",
            "muniz@company.com",
            -10,
            Carbon::now()->addDays(3),
        );
        $bool = in_array(PaymentResource::$AMOUNT_DUE_LESS_EQUAL_ZERO, $validation);

        $this->assertTrue($bool);
    }

    public function test_validation_amount_due_date_less_current(): void
    {
        $payment = new Payment();

        $validation = $payment->New(
            1,
            "Rodrigo Muniz",
            "111111",
            "muniz@company.com",
            -10,
            "2022-06-12",
        );
        $bool = in_array(PaymentResource::$DUE_DATE_LESS_CURRENT_DATE, $validation);

        $this->assertTrue($bool);
    }

    public function test_validation_pay_correct(): void
    {
        $payment = new Payment();
        $payment->id = 1;
        $payment->name = "Rodrigo Muniz";
        $payment->governmentId = "1000";
        $payment->paid = false;
        $payment->email = "muniz@company.com";

        $validation = $payment->Pay(Carbon::now(), 1000, "Muniz");
        
        $this->assertEquals($validation, []);
    }

    public function test_validation_pay_payment_paid(): void
    {
        $payment = new Payment();
        $payment->id = 1;
        $payment->name = "Rodrigo Muniz";
        $payment->governmentId = "1000";
        $payment->paid = true;
        $payment->email = "muniz@company.com";

        $validation = $payment->Pay(Carbon::now(), 1000, "Muniz");
        $bool = in_array(PaymentResource::$PAID, $validation);

        $this->assertTrue($bool);
    }

    
}