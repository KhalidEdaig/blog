<?php

namespace App\Http\Controllers\Post\Resources\Base;

use App\Http\Controllers\Category\Resources\Base\CategoryResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'slug' => $this->slug,
      'body' => $this->body,
      'image_url' => $this->image,
      'published' => \boolval($this->published),
      'category' => new CategoryResource($this->whenLoaded('category')),
      'user' => $this->whenLoaded('user'),
      'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
    ];
  }
}
