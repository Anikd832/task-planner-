<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoutineResource extends JsonResource
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
            'user_id' => $this->user_id,

            'subject_id' => $this->subject_id,
            'subject' => $this->subject,

            'teacher_id' => $this->teacher_id,
            'teacher' => $this->teacher,

            'day_id' => $this->day_id,
            'day' => $this->day,

            'room_no' => $this->room_no,
            'from' => $this->from,
            'to' => $this->to,

            'status' => $this->status,
            'status_text' => $this->statuses($this->status),
            'status_badge' => $this->statusBadge($this->status),

            'user' => $this->whenLoaded('user', function() {
                return new UserResource($this->user);
            })
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
