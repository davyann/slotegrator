<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'image_url' => $this->resource->images->where('is_main', true)->first()->url ?? null,
            'category' => $this->resource->categories->first()?->name,
            'images' =>  ProductImageResource::collection($this->whenLoaded('images')),

        ];

        if (Auth::check()) {
            $data['is_favorite'] = (bool) $this->resource->is_favorite;
        }

        return $data;
    }
}
