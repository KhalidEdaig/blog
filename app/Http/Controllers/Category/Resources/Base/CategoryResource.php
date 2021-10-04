<?php

namespace App\Http\Controllers\Category\Resources\Base;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'slug' => $this->slug,
      'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
    ];
  }
}
