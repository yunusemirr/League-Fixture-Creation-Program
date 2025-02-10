<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            "id" =>$this->id,
            "title" => $this->title,
            "content" => $this->content,
            "images" => $this->whenLoaded('files', function(){
                return $this->files?->where('type', 'article_images')?->map(function($image){
                    return $image->url;
                });
            }),
            "cover_image" => $this->cover_image,
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
