<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacistResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'salary' => $this->salary,
            'role' => $this->role,
            'creation_date' => $this->created_at->format('Y-m-d h:i'),
        ];
    }
}
