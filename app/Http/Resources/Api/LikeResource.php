<?php

namespace App\Http\Resources\Api;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'user' => $this->user,
            'target' => $this->post->slug,
            'created_at' => $this->created_at,
        ];
    }
}
