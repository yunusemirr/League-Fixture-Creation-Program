<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\User\UserResource;
use App\Models\School\AttendaceType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.us
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->resource == null)
            return [];

        return [
            ...UserResource::make($this->student)->toArray($request),
            'type' => $this->type,
            'lesson_id' => $this->lesson_id,
        ];
    }
}
