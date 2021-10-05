<?php

namespace App\Http\Controllers\Post;

use App\Enums\eRespCode;
use App\Http\Controllers\Post\Requests\CreatePostRequest;
use App\Http\Controllers\Post\Requests\ForceDeletePostRequest;
use App\Http\Controllers\Post\Requests\UpdatePostRequest;
use App\Http\Controllers\Post\Resources\Base\PostResource;
use App\Http\Controllers\Post\Resources\Pagination\PostPaginationResourceCollection;
use App\Http\Controllers\Post\Services\PostService;
use App\Http\Controllers\ResponseController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends ResponseController
{

  private $postService;
  private $auth;
  public function __construct(PostService $postService)
  {
    parent::__construct();
    $this->postService = $postService;
    $this->auth = auth()->user();
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {

      $published = \request()->has('published')  ? request()->published : null;

      $sorted = \request()->has('sorted')  ? request()->sorted : null;
      $this->auth->hasRole('admin')
        ? $posts = $this->postService->getByPagination($published, request()->user_id, $sorted)
        : $posts = $this->postService->getByPagination($published, auth()->user()->id, $sorted);
      return $this->resp->ok(
        eRespCode::C_LISTED_200_00,
        new PostPaginationResourceCollection($posts)
      );
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
    if (!auth()->user()->can('view', $post))
      return $this->resp->guessResponse(eRespCode::_403_NOT_AUTHORIZED);

    try {
      return $this->resp->ok(
        eRespCode::P_GET_200_03,
        new PostResource($post->load('category'))
      );
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreatePostRequest $request)
  {
    if (!$request->user()->can('create', Post::class))
      return $this->resp->guessResponse(eRespCode::_403_NOT_AUTHORIZED);

    try {
      return $this->resp->created(
        eRespCode::P_CREATED_201_00,
        new PostResource($this->postService->create($request->validated() + ['user_id' => $this->auth->id])->load('category'))
      );
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePostRequest $request, Post $post)
  {
    if (!$request->user()->can('update', $post))
      return $this->resp->guessResponse(eRespCode::_403_NOT_AUTHORIZED);
    try {
      return $this->resp->ok(
        eRespCode::P_UPDATED_200_01,
        new PostResource($this->postService->update($request->validated(), $post)->load('category'))
      );
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    if (!auth()->user()->can('delete', $post))
      return $this->resp->guessResponse(eRespCode::_403_NOT_AUTHORIZED);

    try {
      $this->postService->remove($post);
      return $this->resp->ok(eRespCode::P_DELETED_200_02);
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  public function publishOrUnPublish($postId)
  {
    $post = Post::find($postId);
    $post->published = !$post->published;
    $post->save();
    return $this->resp->ok(eRespCode::P_UPDATED_200_01, new PostResource($post->load('category')));
  }
}
