<?php

namespace App\Http\Resources\Attendace;

use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->resource == null)
            return [];
        $c_now = now();
        return [
            'id' => $this->id,
            'start_time' => $c_now->setTimeFromTimeString($this->start_time)->format('H:i'),
            'end_time' => $c_now->setTimeFromTimeString($this->end_time)->format('H:i'),
            'day' => $this->day,
            'teacher' => $this->when(($this->relationLoaded('teacher')), UserResource::make($this->teacher)),
            'lesson' => LessonResource::make($this->lesson),
            'group' => GroupResource::make($this->group),
        ];
    }
}
