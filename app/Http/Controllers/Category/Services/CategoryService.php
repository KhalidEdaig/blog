<?php

namespace App\Http\Controllers\Category\Services;

use App\Models\Category;

class CategoryService
{


  public function getByPagination()
  {
    return Category::paginate();
  }

  public function getById(string $id)
  {
    return Category::findOrFail($id);
  }

  public function getAll()
  {
    return Category::all();
  }

  public function create(array $fields)
  {
    return Category::create($fields);
  }

  public function update(array $fields, Category $category)
  {
    $category->update($fields);
    return $category;
  }

  public function remove(Category $category)
  {
    return  $category->delete();
  }
}
