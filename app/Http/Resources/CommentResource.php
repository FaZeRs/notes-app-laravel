<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'id'         => $this->uuid,
            'body'       => $this->body,
            'user'       => new UserResource($this->whenLoaded('user')),
            'note'       => new NoteResource($this->whenLoaded('note')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
