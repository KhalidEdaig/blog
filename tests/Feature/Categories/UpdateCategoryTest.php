<?php

namespace Tests\Feature\Users;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateCategoryTest  extends TestCase
{
  use RefreshDatabase;


  public $token;
  public $user;

  public function setUp(): void
  {
    parent::setUp();
    $role1 = Role::firstOrCreate(['name' => 'admin']);
    $this->user = User::create([
      'username' => 'admin',
      'email' => 'admin@blog.com',
      'password' => 'password',
    ]);
    $this->user->assignRole($role1);
    $response = $this->postJson('/api/auth/signin', [
      'email' => "admin@blog.com",
      'password' => 'password'
    ]);

    $this->token = 'Bearer ' . json_decode($response->content())->access_token;
    Category::factory(1)->create();
  }

  public function testCanNotUpdateCategoryShouldReturenInvalidData()
  {

    $this->putJson('api/categories/' . Category::first()->id, [], ['authorization' => $this->token])
      ->assertStatus(422);
  }

  public function testCanUpdateCategory()
  {
    $data = [
      'name' => 'test test'
    ];
    $this->putJson('api/categories/' . Category::first()->id, $data, ['authorization' => $this->token])
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'name' => $data['name']
        ]
      ]);
  }
}
