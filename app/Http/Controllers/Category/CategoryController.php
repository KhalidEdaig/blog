<?php

namespace App\Http\Controllers\Category;

use App\Enums\eRespCode;
use App\Http\Controllers\Category\Requests\CreateCategoryRequest;
use App\Http\Controllers\Category\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Category\Resources\Base\CategoryResource;
use App\Http\Controllers\Category\Resources\Base\CategoryResourceCollection;
use App\Http\Controllers\Category\Services\CategoryService;
use App\Http\Controllers\ResponseController;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends ResponseController
{

  private $categoryService;
  public function __construct(CategoryService $categoryService)
  {
    parent::__construct();
    $this->categoryService = $categoryService;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      return $this->resp->ok(eRespCode::C_LISTED_200_00, new CategoryResourceCollection($this->categoryService->getAll()));
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
  public function store(CreateCategoryRequest $request)
  {
    try {
      return $this->resp->created(eRespCode::C_CREATED_201_00, new CategoryResource($this->categoryService->create($request->validated())));
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    try {
      return $this->resp->ok(eRespCode::C_GET_200_03, new CategoryResource($category));
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCategoryRequest $request, Category $category)
  {
    try {
      return $this->resp->ok(eRespCode::C_UPDATED_200_01, new CategoryResource($this->categoryService->update($request->all(), $category)));
    } catch (\Throwable $th) {
      Log::error($th);
      return $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    return $this->categoryService->remove($category)
      ? $this->resp->ok(eRespCode::C_DELETED_200_02)
      : $this->resp->guessResponse(eRespCode::_500_INTERNAL_ERROR);
  }
}
