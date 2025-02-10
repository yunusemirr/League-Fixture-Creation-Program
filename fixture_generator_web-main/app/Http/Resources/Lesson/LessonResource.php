<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            "name" => $this->name,
            "code" => $this->code,
            "color" => str_replace('#', '0xff', $this->color),
            "icon" => $this->icon,
        ];
    }
}
