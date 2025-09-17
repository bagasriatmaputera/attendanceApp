<?php

namespace App\Http\Resources;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmlployeeResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'department_id' => new DepartmentResource($this->whenLoaded('department'))
        ];
    }
}
