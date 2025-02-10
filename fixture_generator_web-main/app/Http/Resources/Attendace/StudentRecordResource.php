<?php

namespace App\Http\Resources\Attendace;

use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentRecordResource extends JsonResource
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
        $now = now();
        return [
            'id' => $this->id,
            'start_time' => $now->setTimeFromTimeString($this->groupLesson->start_time)->format('H:i'),
            'end_time' => $now->setTimeFromTimeString($this->groupLesson->end_time)->format('H:i'),
            'lesson' => LessonResource::make($this->lesson),
            'type' => $this->type,
            'date' => $this->created_at->translatedFormat('d F Y'),
        ];
    }
}
