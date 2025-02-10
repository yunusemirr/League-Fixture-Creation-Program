<?php

namespace App\Http\Resources\Trial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrialExamResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "type" => match ($this?->type) {
                "yks" => "YKS Sınavı",
                "language" => "Dil Sınavı",
                default => "Diğer Sınavlar"
            },
            "exam_date" => $this->exam_date->translatedFormat("d F Y"),
            "is_past" => now()->isAfter($this->exam_date),
            "status" => 1,
        ];
    }
}
