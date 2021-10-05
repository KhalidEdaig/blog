<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Reset cached roles and permissions
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Permission::firstOrCreate(['name' => 'posts.*']);
    Permission::firstOrCreate(['name' => 'posts.create']);
    Permission::firstOrCreate(['name' => 'posts.update']);
    Permission::firstOrCreate(['name' => 'posts.delete']);
    Permission::firstOrCreate(['name' => 'posts.view']);

    Permission::firstOrCreate(['name' => 'categories.*']);
    Permission::firstOrCreate(['name' => 'categories.view']);

    $role1 = Role::firstOrCreate(['name' => 'admin']);
    $role2 = Role::firstOrCreate(['name' => 'publisher']);

    $admin = User::create([
      'username' => 'admin',
      'email' => 'admin@blog.com',
      'password' => 'password',
    ]);

    $admin->assignRole($role1->name);
    $admin->givePermissionTo('categories.*');
    $admin->givePermissionTo('posts.update');
    $admin->givePermissionTo('posts.delete');
    $admin->givePermissionTo('posts.view');

    $publisher = User::create([
      'username' => 'publisher1',
      'email' => 'publisher1@blog.com',
      'password' => 'password',
    ]);
    $publisher->assignRole($role2->name);
    $publisher->givePermissionTo('posts.*');
    // $publisher->givePermissionTo('posts.create');
    // $publisher->givePermissionTo('posts.update');
    // $publisher->givePermissionTo('posts.delete');
    // $publisher->givePermissionTo('posts.view');
    $publisher->givePermissionTo('categories.view');

    $publisher = User::create([
      'username' => 'publisher2',
      'email' => 'publisher2@blog.com',
      'password' => 'password',
    ]);

    $publisher->assignRole($role2->name);
    $publisher->givePermissionTo('posts.*');
    // $publisher->givePermissionTo('posts.create');
    // $publisher->givePermissionTo('posts.update');
    // $publisher->givePermissionTo('posts.delete');
    // $publisher->givePermissionTo('posts.view');
    $publisher->givePermissionTo('categories.view');
  }
}
