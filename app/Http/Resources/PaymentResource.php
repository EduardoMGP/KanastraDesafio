<?php

namespace App\Http\Resources;

use App\Traits\GenericResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{

    use GenericResourceTrait;

    public function toArray($request)
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data'    => isset($this->debtId) ? $this->resource : []
        ];
    }
}
