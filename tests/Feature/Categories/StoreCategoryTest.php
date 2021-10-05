<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreCategoryTest  extends TestCase
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
  }

  public function testCanNotStoreCategoryShouldReturenForbadden()
  {
    $this->user->removeRole('admin');

    $this->postJson('api/categories', [], ['authorization' => $this->token])
      ->assertStatus(403);
  }

  public function testCanNotStoreCategoryShouldReturenInvalidData()
  {

    $this->postJson('api/categories', [], ['authorization' => $this->token])
      ->assertStatus(422);
  }

  public function testCanStoreCategory()
  {
    $data = [
      'name' => 'test test'
    ];
    $this->postJson('api/categories', $data, ['authorization' => $this->token])
      ->assertStatus(201)
      ->assertJson([
        'data' => [
          'name' => $data['name']
        ]
      ]);
  }
}
