<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
  use RefreshDatabase;


  public $token;
  public $otherToken;
  public $pub;
  public function setUp(): void
  {
    parent::setUp();
    $role1 = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::create([
      'username' => 'admin',
      'email' => 'admin@blog.com',
      'password' => 'password',
    ]);
    $admin->assignRole($role1->name);

    $this->pub = User::create([
      'username' => 'publisher',
      'email' => 'publisher@blog.com',
      'password' => 'password',
    ]);
    $role1 = Role::firstOrCreate(['name' => 'publisher']);
    $this->pub->assignRole($role1);

    $response = $this->postJson('/api/auth/signin', [
      'email' => "admin@blog.com",
      'password' => 'password'
    ]);

    $this->token = 'Bearer ' . json_decode($response->content())->access_token;
  }

  public function testCanGetAllUsersOnlyByAdmin()
  {
    $this->getJson('api/users', ['authorization' => $this->token])
      ->assertStatus(200)->assertJsonCount(1, 'data');
  }

  public function testCanBlockOrUnblockUserOnlyByAdmin()
  {
    $this->putJson('api/users/' . $this->pub->id . '/bloc-or-unbloc', [], ['authorization' => $this->token])
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'is_active' => $this->pub->active
        ]
      ]);
  }
}
