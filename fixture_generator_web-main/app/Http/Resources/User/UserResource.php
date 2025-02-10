<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Group\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request = null): array
    {

        if(is_null($this->resource))
            return [];

        $return = array();

        $arr = [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'tc' => $this->tc,
            'phone' => $this->phone,
            'address' => $this->address,
            'role_id' => $this->role_id,
            'student_no' => $this->student_no,
            'language' => $this->language,
            'profile_image' => $this->profile_image,
            'full_name' => $this->full_name,
            'parent_id' => $this->parent_id,
            'group' => $this->when(($this->role_id == 1 && $this->relationLoaded('group')), GroupResource::make($this->group), null),
            'students' => $this->when(($this->role_id == 2 && $this->relationLoaded('students')), UserCollection::make($this->students), []),
        ];

        return $arr;
    }
}
