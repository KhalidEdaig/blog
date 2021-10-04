<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GetCategoriessTest extends TestCase
{
  use RefreshDatabase;

  public $token;
  public $user;
  public $payload;

  public function setUp(): void
  {
    parent::setUp();

    User::create([
      'username' => 'user',
      'email' => 'user@blog.com',
      'password' => 'password'
    ]);

    Permission::create(['name' => 'categories.*']);
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'publicher']);

    $response = $this->postJson('/api/auth/login', [
      'email' => 'user@blog.com',
      'password' => 'password'
    ]);

    Log::info($response);

    // $this->token = 'Bearer ' . json_decode($response->content())->access_token;

    // $this->payload = [
    //   [
    //     'name' => 'test1',
    //   ],
    //   [
    //     'name' => 'test1 test2',
    //   ]
    // ];
    // Category::insert($this->payload);
  }

  public function testCanNotGetCategories()
  {
    $this->markTestSkipped();
    $this->getJson('api/categories', ['authorization' => $this->token])
      ->assertStatus(403);
  }
}
