<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'           => $this->name,
            'email'          => $this->email,
            'identification' => $this->identification,
            'account' => [
                'account_number'  => $this->account->account_number ?? null,
                'balance'  => $this->account->balance ?? null
            ]
        ];
    }
}
