<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
  use HasFactory, Uuid;

  protected $fillable = ['name', 'slug'];

  protected $guarded = [];

  protected $primaryKey = 'id';

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function setNameAttribute($value)
  {
    $this->attributes['name'] = $value;
    $this->attributes['slug'] = Str::slug($value);
  }
}
