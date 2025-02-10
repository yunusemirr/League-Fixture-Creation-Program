<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class TutorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return match($this->method()){
            'POST' => $this->store(),
            default => $this->store()
        };
    }

    public function store(){
        return [
            'lesson_id' => 'required|numeric|exists:lessons,id',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ];
    }
}
