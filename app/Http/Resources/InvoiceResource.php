<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'debtId' => $this->debtId,
            'name' => $this->name,
            'governmentId' => $this->governmentId,
            'email' => $this->email,
            'debtAmount' => $this->debtAmount,
            'debtDueDate' => $this->debtDueDate,
            'isPaid' => $this->isPaid,
            'payments' => $this->payments
        ];
    }
}
