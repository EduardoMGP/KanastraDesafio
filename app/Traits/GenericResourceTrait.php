<?php

namespace App\Traits;

/**
 * Trait GenericResource
 * @package App\Traits
 * @property $code
 * @property $message
 * @property $success
 * @property $resource
 * @property $collection
 *
 */
trait GenericResourceTrait
{

    public function __construct($resource, $message = null, $success = true, $code = 200)
    {
        if ($resource) {
            parent::__construct($resource);
        }
        $this->code = $code;
        $this->message = $message;
        $this->success = $success;
    }

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data'    => isset($this->resource) ? $this->collection : [],
        ];
    }

    /**
     * @param $request
     * @param $response
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->code);
    }

}
