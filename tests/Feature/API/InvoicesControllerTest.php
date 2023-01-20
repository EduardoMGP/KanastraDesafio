<?php

namespace Tests\Feature\API;

use App\Models\Invoices;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class InvoicesControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_post_endpoint_invoice()
    {
        $invoices = Invoices::factory(3)->make();
        $csv[] = 'name,governmentId,email,debtAmount,debtDueDate,debtId';
        $invoices->each(function ($invoice) use (&$csv) {
            $csv[] = $invoice->name . ',' . $invoice->governmentId . ',' . $invoice->email . ', '
                . $invoice->debtAmount . ',' . $invoice->debtDueDate . ',' . $invoice->debtId;
        });

        $response = $this->call(
            'POST',
            '/api/invoices',
            [],
            $this->prepareCookiesForJsonRequest(),
            [],
            $this->transformHeadersToServerVars([
                'Content-Type' => 'text/plain'
            ]),
            implode("\n", $csv)
        );

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'success',
            'data' => []
        ]);

        $response->assertJson([
            'message' => __('api.invoices.created', ['quantity' => 3]),
            'success' => true,
            'data'    => []
        ]);

    }

    public function test_post_endpoint_invoice_csv_invalid()
    {
        $invoices = Invoices::factory(3)->make();
        $csv[] = 'name,governmentId,email,debtAmount,debtDueDate,debtId';
        $invoices->each(function ($invoice) use (&$csv) {
            $csv[] = $invoice->governmentId . ',' . $invoice->email . ', '
                . $invoice->debtAmount . ',' . $invoice->debtDueDate;
        });

        $response = $this->call(
            'POST',
            '/api/invoices',
            [],
            $this->prepareCookiesForJsonRequest(),
            [],
            $this->transformHeadersToServerVars([
                'Content-Type' => 'text/plain'
            ]),
            implode("\n", $csv)
        );

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message',
            'success',
            'data' => []
        ]);

        $response->assertJson([
            'message' => __('api.invalid_csv'),
            'success' => false,
            'data'    => []
        ]);

    }

    public function test_get_endpoint_list_all_invoices()
    {

        Invoices::factory(10)->create();
        $response = $this->getJson('/api/invoices');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'success',
            'data' => [
                '*' => [
                    'created_at',
                    'debtAmount',
                    'debtDueDate',
                    'debtId',
                    'email',
                    'governmentId',
                    'isPaid',
                    'name',
                    'payments',
                    'updated_at',
                    'valuePaid',
                ]
            ]
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'message', 'data'])
                ->has('data', 10);
            $json->whereAll([
                'success' => true,
                'message' => __('api.invoices.retrieved'),
            ])->etc();
        });
    }

    public function test_get_endpoint_invoice_by_debtid()
    {

        $invoice = Invoices::factory()->createOne();
        $response = $this->getJson('/api/invoice/' . $invoice->debtId);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'success',
            'data' => []
        ]);

        $response->assertJson(function (AssertableJson $json) use ($invoice) {
            $json->hasAll(['success', 'message', 'data']);
            $json->whereAll([
                'success' => true,
                'message' => __('api.invoices.one_retrieved', ['id' => $invoice->debtId]),
            ]);
        });

        $response = $this->getJson('/api/invoice/' . $invoice->debtId + 1);
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
            'success',
            'data' => []
        ]);

        $response->assertJson(function (AssertableJson $json) use ($invoice) {
            $json->hasAll(['success', 'message', 'data']);
            $json->whereAll([
                'success' => false,
                'message' => __('api.invoices.not_found', ['id' => $invoice->debtId + 1]),
            ]);
        });
    }
}
