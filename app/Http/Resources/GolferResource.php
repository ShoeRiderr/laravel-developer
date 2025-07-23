<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GolferResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'debitor_account' => $this->debitor_account,
            'name' => $this->name,
            'email' => $this->email,
            'born_at' => $this->born_at,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
