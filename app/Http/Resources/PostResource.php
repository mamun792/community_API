<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            //'content' => $this->content,
            'price' => $this->price,
            'location' => $this->location,
            'model' => $this->model,
            'year' => $this->year,
            "description" => $this->description,
            "user_id" => $this->user_id,
            'user_id' => $this->user_id,
            'likes' => $this->likes_count,
            'comments' => $this->comments_count,
            'images' => $this->images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
