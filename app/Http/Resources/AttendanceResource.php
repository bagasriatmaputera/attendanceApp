<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'employee_id' => new EmlployeeResource($this->whenLoaded('employee')),
            'attendance_id' => $this->attendance_id,
            'clock_in' => $this->clock_in,
            'clock_out' => $this->clock_out,
        ];
    }
}
