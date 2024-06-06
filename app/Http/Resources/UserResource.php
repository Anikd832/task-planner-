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
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'contact' => $this->contact,
            'roles' => $this->roles,
            'status' => $this->status,
            'status_text' => $this->statuses($this->status),
            'status_badge' => $this->statusBadge($this->status),
        ];
    }

    /**
     * get status name
     */
    protected function statuses($status): string
    {
        return [
            '1' => 'Active',
            '2' => 'Inactive',
        ][$status] ?? '---';
    }

    /**
     * get status bg
     */
    protected function statusBadge($status): string
    {
        return [
            '1' => 'green',
            '2' => 'secondary',
        ][$status] ?? 'default';
    }
}
