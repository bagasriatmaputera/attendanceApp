<?php

namespace App\Http\Resources;

use App\Filament\Resources\Employees\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceHistoryResource extends JsonResource
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
            'attendance_id' => new AttendanceResource($this->whenLoaded('attendance')),
            'date_attendance' => $this->date_attendance,
            'attendance_type' => $this->attendance_type,
            'description' => $this->description,
        ];
    }
}
