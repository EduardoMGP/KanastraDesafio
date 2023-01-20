<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentCreateRequest;
use App\Http\Resources\Collections\PaymentCollectionResource;
use App\Http\Resources\PaymentResource;
use App\Models\Invoices;
use App\Models\Payments;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return PaymentResource
     */
    public function create(PaymentCreateRequest $request)
    {
        $content = $request->all();
        $invoice = Invoices::query()->where('debtId', $content['debtId'])->first();
        if ($invoice) {
            $payment = new Payments();
            $payment->debtId = $content['debtId'];
            $payment->paidAt = $content['paidAt'];
            $payment->paidAmount = $content['paidAmount'];
            $payment->paidBy = $content['paidBy'];
            $payment->save();
            if ($invoice->isPaid) {
                $invoice->paid = true;
                $invoice->save();
            }
            return PaymentResource::make(
                $payment, __('api.payments.created'), true, ResponseAlias::HTTP_CREATED
            );
        } else {
            return PaymentResource::make(
                null, __('api.invoices.not_found', ['id' => $content['debtId']]),
                false, ResponseAlias::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $debtId
     * @return PaymentCollectionResource
     */
    public function payments($debtId)
    {
        return PaymentCollectionResource::make(
            Payments::query()->where('debtId', $debtId)->get(),
            __('api.payments.retrieved', ['id' => $debtId]), true
        );
    }
}
