<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [];
        }
        $attributes = parent::toArray($request);

        return [
            'type' => 'product',
            'id' => $this->id,
            'attributes' => $attributes,
            'relationships' => [],
        ];
    }
}
