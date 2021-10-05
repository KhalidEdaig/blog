<?php

namespace App\Http\Controllers\Post\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PostService
{

  public function getByPagination($isPublished = null, string $user_id = null, string $isSorted = null)
  {

    return Post::when($user_id, function (Builder $q) use ($user_id) {
      $q->whereUserId($user_id);
    })
      ->when($isPublished !== null, function (Builder $q) use ($isPublished) {
        $q->wherePublished(filter_var($isPublished, FILTER_VALIDATE_BOOLEAN));
      })
      ->when($isSorted, function (Builder $q) {
        $q->orderBy('created_at', 'ASC')->get();
      })
      ->with(['category', 'user:id,username'])
      ->paginate();
  }

  public function getById(string $id)
  {
    return Post::findOrFail($id);
  }

  public function getAll()
  {
    return Post::all();
  }

  public function create(array $fields)
  {
    return Post::create($fields);
  }

  public function update(array $fields, Post $post)
  {
    $post->update($fields);
    return $post;
  }

  public function remove(Post $post)
  {
    return $post->delete();
  }
}
