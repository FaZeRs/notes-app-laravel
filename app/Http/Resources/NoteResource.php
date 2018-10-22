<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'body'       => $this->body,
            'is_public'  => $this->is_public,
           // 'user'       => $this->whenLoaded('user'),
            'comments'   => $this->whenLoaded('comments'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
