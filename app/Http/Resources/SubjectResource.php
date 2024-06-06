<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'title' => $this->title,
            'full_name' => $this->full_name
            // 'start_date_formated' => date('d F, Y', strtotime($this->start_date)),
            // 'start_time' => $this->start_time,
            // 'start_time_formated' => date('h:i a', strtotime($this->start_time)),
            // 'repeat_type' => $this->repeat_type,

            // 'status' => $this->status,

            // 'status_text' => $this->statuses($this->status),

            // 'status_badge' => $this->statusBadge($this->status),

            // 'user' => $this->whenLoaded('user', function() {
            //     return new UserResource($this->user);
            // })
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
            '1' => 'badge badge-success',
            '2' => 'badge badge-secondary',
        ][$status] ?? 'badge badge-default';
    }
}
