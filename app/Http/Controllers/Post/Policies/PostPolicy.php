<?php

namespace App\Http\Controllers\Post\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
  use HandlesAuthorization;

  public function view(User $user, Post $post)
  {
    return $user->hasAnyRole('admin', 'publisher') && $user->id === $post->user_id;
  }

  public function store(User $user)
  {
    return true;
  }

  public function update(User $user, Post $post)
  {
    return $user->hasAnyRole('admin', 'publisher') && $user->id === $post->user_id;
  }

  public function delete(User $user, Post $post)
  {
    return $user->hasAnyRole('admin', 'publisher') && $user->id === $post->user_id;
  }
}
