<?php

namespace App\Http\Controllers\Category\Resources\Pagination;

use App\Http\Controllers\Category\Resources\Base\CategoryResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryPaginationResourceCollection extends ResourceCollection
{

  public function toArray($request)
  {
    return [
      'Category' => CategoryResource::collection($this->collection),
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
