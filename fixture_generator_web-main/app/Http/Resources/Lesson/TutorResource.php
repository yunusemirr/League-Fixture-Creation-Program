<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorResource extends JsonResource
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

        return [
            "id" => $this->id,
            "status" => $this->status,

            "start_datetime" => $this->tutorGroup?->start_datetime ? $this?->start_datetime?->translatedFormat('d F Y H:i') : $this?->requested_start_datetime?->translatedFormat('d F Y H:i'),
            "end_datetime" => $this->tutorGroup?->end_datetime ? $this?->tutorGroup?->end_datetime?->translatedFormat('d F Y H:i') : $this?->requested_end_datetime?->translatedFormat('d F Y H:i'),
            "note" => $this->note,
            "student" => UserResource::make($this?->student),
            "teacher" => $this->when($this?->tutorGroup?->teacher, UserResource::make($this?->tutorGroup?->teacher), null),
            "lesson" => LessonResource::make($this?->lesson),
            // "lesson" => $this->when($this?->tutorGroup?->lesson,LessonResource::make($this?->tutorGroup?->lesson),null),
        ];
    }
}
