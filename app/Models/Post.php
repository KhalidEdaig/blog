<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
  use HasFactory, Uuid;

  protected $fillable = ['title', 'slug', 'body', 'published', 'image', 'category_id', 'user_id'];

  protected $primaryKey = 'id';

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = $value;
    $this->attributes['slug'] = Str::slug($value);
  }
}
