<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'SKU' => $this->SKU,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'discount_id' => $this->discount_id,
            'user_id' => $this->user_id,
            'tag' => $this->tag,
            'views' => $this->views,
            'shared' => $this->shared,
            'thumb' => $this->thumb,
            'status' => $this->status,
            'garelly' => $this->garelly,
        ];
    }
}
