<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Group\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'send_date' => $this->send_date->format("d F Y H:i"),
        ];

        return $arr;
    }
}
