<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource
            ->makeVisible([
                'first_name',
                'last_name',
                'phone',
                'country',
                'address',
                'city',
                'postal_code',
                'bio',
                'avatar_url'
            ])
            ->makeHidden(['password'])
            ->toArray();
    }
}
