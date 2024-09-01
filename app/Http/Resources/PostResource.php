<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostResource
 * @package App\Http\Resources
 * @mixed \App\Models\Post
 */
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
            'title' => $this->title,
            'content' => $this->content,
            'gps_latitude' => $this->gps_latitude,
            'gps_longitude' => $this->gps_longitude,
            'country' => $this->country,
            'city' => $this->city,
            'district' => $this->district,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'files' => FileResource::collection($this->files),
        ];
    }
}
