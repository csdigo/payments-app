<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_webhook_update_payment_found(): void
    {
        $pag = new Payment();
        $pag->name = "John Doe";
        $pag->governmentId = "333333";
        $pag->email = "johndoe@kanastra.com.br";
        $pag->debtAmount = 1000000.00;
        $pag->debtDueDate = "2022-10-12";
        $pag->debtId = 8292;

        Payment::create($pag->toArray());

        $response = $this->postJson('/api/hook/payment', [
            "debtId" => "8292",
            "paidAt" => "2022-06-09 10:00:00",
            "paidAmount" => 10000.00,
            "paidBy" => "Muniz"
        ]);

        $response->assertStatus(201);
    }

    public function test_webhook_update_payment_not_found(): void
    {
        $pag = new Payment();
        $pag->name = "John Doe";
        $pag->governmentId = "333333";
        $pag->email = "johndoe@kanastra.com.br";
        $pag->debtAmount = 1000000.00;
        $pag->debtDueDate = "2022-10-12";
        $pag->debtId = 8292;

        Payment::create($pag->toArray());

        $response = $this->postJson('/api/hook/payment', [
            "debtId" => "8293",
            "paidAt" => "2022-06-09 10:00:00",
            "paidAmount" => 10000.00,
            "paidBy" => "Muniz"
        ]);

        $response->assertStatus(404);
    }
}