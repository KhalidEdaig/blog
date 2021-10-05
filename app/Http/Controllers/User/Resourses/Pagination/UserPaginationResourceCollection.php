<?php

namespace App\Http\Controllers\User\Resourses\Pagination;

use App\Http\Controllers\User\Resources\Base\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPaginationResourceCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'users' => UserResource::collection($this->collection),
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
