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
            'reference' => $this->reference,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'price' => $this->price,
            'old_price' => $this->old_price,
            // 'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
