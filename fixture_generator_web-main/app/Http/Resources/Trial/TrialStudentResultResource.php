<?php

namespace App\Http\Resources\Trial;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrialStudentResultResource extends JsonResource
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
            "trial_exam" => TrialExamResource::make($this->trialExam),
            "student" => UserResource::make($this->student),
            "files" => $this->files,
            "score" => $this->score ?? 0,
            "net" => $this->net ?? 0,
            "wrong" => $this->wrong ?? 0,
            "empty" => $this->empty ?? 0,
            "correct" => $this->correct ?? 0,
        ];
    }
}
