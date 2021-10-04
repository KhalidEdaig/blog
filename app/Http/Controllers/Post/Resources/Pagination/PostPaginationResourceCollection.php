<?php

namespace App\Http\Controllers\Post\Resources\Pagination;

use App\Http\Controllers\Post\Resources\Base\PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostPaginationResourceCollection extends ResourceCollection
{

  public function toArray($request)
  {
    return [
      'posts' => PostResource::collection($this->collection),
      'meta' => [
        'total' => $this->total(),
        'count' => $this->count(),
        'per_page' => $this->perPage(),
        'current_page' => $this->currentPage(),
        'total_pages' => $this->lastPage()
      ]
    ];
  }
}
