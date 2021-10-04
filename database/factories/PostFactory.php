<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Post::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->sentence(),
      'body' => $this->faker->paragraph(),
      'image' => $this->faker->url(),
      'published' => rand(0, 1),
      'category_id' =>  Category::all()->random()->id,
      'user_id' => User::all()->random()->id,
    ];
  }
}
