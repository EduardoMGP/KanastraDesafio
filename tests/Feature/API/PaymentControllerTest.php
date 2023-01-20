<?php

namespace Tests\Feature\API;

use App\Models\Invoices;
use App\Models\Payments;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_endpoint_payments()
    {
        $invoice = Invoices::factory()->make();
        $invoice->save();

        $payment = Payments::factory()->make([
            'debtId'     => $invoice->debtId,
            'paidAmount' => $invoice->debtAmount,
        ]);
        $payment->save();

        $response = $this->get('/api/payment/' . $invoice->debtId);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'success',
                'data' => []
            ])
            ->assertJson([
                'message' => __('api.payments.retrieved', ['id' => $invoice->debtId]),
                'success' => true,
                'data'    => []
            ]);

    }


    public function test_post_endpoint_payment()
    {
        $invoice = Invoices::factory()->make();
        $invoice->save();

        $payment = Payments::factory()->make([
            'debtId'     => $invoice->debtId,
            'paidAmount' => $invoice->debtAmount,
        ]);

        $response = $this->post('/api/payment', $payment->toArray());
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'success',
                'data' => []
            ])
            ->assertJson([
                'message' => __('api.payments.created'),
                'success' => true,
                'data'    => []
            ]);

    }

    public function test_post_endpoint_payment_not_found()
    {

        $payment = Payments::factory()->make();
        $response = $this->post('/api/payment', $payment->toArray());
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'success',
                'data' => []
            ])
            ->assertJson([
                'message' => __('api.payments.not_found', ['id' => $payment->debtId]),
                'success' => false,
                'data'    => []
            ]);

    }

    public function test_post_endpoint_payment_invalid_parameters()
    {

        $payment = Payments::factory()->make();
        $payment = $payment->toArray();
        unset($payment['paidAmount']);
        unset($payment['paidAt']);
        $response = $this->post('/api/payment', $payment);
        $response
            ->assertStatus(400)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => []
            ])
            ->assertJson([
                'message' => __('api.invalid_parameters'),
                'success' => false,
                'data' => [
                    'paidAt' => [
                        __('api.required', ['attribute' => 'paid at'])
                    ],
                    'paidAmount' => [
                        __('api.required', ['attribute' => 'paid amount'])
                    ]
                ]
            ]);

    }

}
