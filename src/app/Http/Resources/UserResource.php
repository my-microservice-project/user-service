<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name . ' ' . $this->resource->last_name,
            'since' => Carbon::make($this->resource->created_at)->format('Y-m-d'),
            'revenue' => 'YAPILACAK',
        ];
    }
}
