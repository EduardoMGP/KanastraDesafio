<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceCreateRequest;
use App\Http\Resources\Collections\InvoiceCollectionResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoices;
use App\Models\TicketsEmailQueues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InvoicesController extends Controller
{

    /**
     * @return InvoiceCollectionResource
     */
    public function index()
    {
        return InvoiceCollectionResource::make(Invoices::all(), __('api.invoices.retrieved'), true);
    }

    /**
     * @param $id
     * @return InvoiceResource
     */
    public function view($id)
    {
        $invoice = Invoices::query()->where('debtId', $id)->first();
        if ($invoice) {
            return InvoiceResource::make($invoice, __('api.invoices.one_retrieved', [
                'id' => $id
            ]), true);
        } else {
            return InvoiceResource::make(
                null, __('api.invoices.not_found', ['id' => $id]),
                false, ResponseAlias::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param Request $request
     * @return InvoiceCollectionResource|InvoiceResource
     */
    public function create(Request $request)
    {

        $content = $request->getContent();
        return $this->createInvoice($content);

    }

    /**
     * @param Request $request
     */
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv' => 'required|file|mimes:csv,txt',
        ], [
            '*.required' => __('api.required', ['attribute' => ':attribute']),
            '*.file'     => __('api.file', ['attribute' => ':attribute']),
            '*.mimes'    => __('api.mimes', ['attribute' => ':attribute']),
        ]);

        if ($validator->fails()) {
            return InvoiceCollectionResource::make($validator->errors()->getMessages(), __('api.invalid_csv'), false, ResponseAlias::HTTP_BAD_REQUEST);
        }

        $file = $request->file('csv');
        $content = file_get_contents($file->getRealPath());
        $newContent = '';
        $contents = explode("\n", $content);
        for ($i = 0; $i < count($contents); $i++) {
            $newContent .= preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $contents[$i]);
            if ($i < count($contents) - 1) {
                $newContent .= "\n";
            }
        }
        return $this->createInvoice($newContent);
    }

    private function createInvoice(string $content)
    {
        $csv = explode("\n", $content);
        if (count($csv) > 1) {
            $header = preg_replace('/(\\n|\\r||\\.)*/', '', $csv[0]);
            if ($header === "name,governmentId,email,debtAmount,debtDueDate,debtId") {

                $csv = array_map('str_getcsv', $csv);
                $header = $csv[0];
                $data = array_slice($csv, 1);

                try {
                    $data = array_map(function ($row) use ($header) {
                        if (count($row) == count($header)) {
                            return array_combine($header, $row);
                        } else throw new \Exception(__('api.invalid_csv'));
                    }, $data);
                } catch (\Exception $e) {
                    return InvoiceCollectionResource::make(null, $e->getMessage(), false, ResponseAlias::HTTP_BAD_REQUEST);
                }

                foreach ($data as $row) {
                    $validator = Validator::make($row, [
                        'name'         => 'required|string',
                        'governmentId' => 'required|integer',
                        'email'        => 'required|email',
                        'debtAmount'   => 'required|numeric|between:0,9999999999.99',
                        'debtDueDate'  => 'required|date',
                        'debtId'       => 'required|integer|between:0,9999999999',
                    ], [
                        '*.required' => __('api.required', ['attribute' => ':attribute']),
                        '*.date'     => __('api.date', ['attribute' => ':attribute']),
                        '*.integer'  => __('api.integer', ['attribute' => ':attribute']),
                        '*.numeric'  => __('api.numeric', ['attribute' => ':attribute']),
                        '*.between' => __('api.between', ['attribute' => ':attribute', 'min' => ':min', 'max' => ':max']),
                        '*.string'   => __('api.string', ['attribute' => ':attribute']),
                        '*.email'    => __('api.email', ['attribute' => ':attribute']),
                    ]);

                    if ($validator->fails()) {
                        return InvoiceCollectionResource::make($validator->errors()->getMessages(), __('api.invalid_csv'), false, ResponseAlias::HTTP_BAD_REQUEST);
                    }
                }

                $alreadyExists = [];
                $created = [];
                foreach ($data as $row) {
                    $invoice = Invoices::query()->where('debtId', $row['debtId'])->first();
                    if (!$invoice) {
                        $invoice = Invoices::create($row);
                        $invoice->debtId = $row['debtId'];
                        $created[] = $invoice;
                        TicketsEmailQueues::query()->create([
                            'email'  => $row['email'],
                            'debtId' => $row['debtId'],
                        ]);
                    } else {
                        $alreadyExists[] = $row['debtId'];
                    }
                }

                if (!empty($created)) {
                    return InvoiceCollectionResource::make(['created' => $created, 'alreadyExists' => $alreadyExists], __('api.invoices.created', ['quantity' => count($created)]), true, ResponseAlias::HTTP_CREATED);
                } else {
                    return InvoiceCollectionResource::make(['alreadyExists' => $alreadyExists], __('api.invoices.nothing_created'), false, ResponseAlias::HTTP_CONFLICT);
                }

            } else {
                return InvoiceResource::make(
                    null, __('api.invalid_csv'),
                    false, ResponseAlias::HTTP_BAD_REQUEST
                );
            }
        } else {
            return InvoiceResource::make(
                null, __('api.invalid_csv'),
                false, ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }

}
