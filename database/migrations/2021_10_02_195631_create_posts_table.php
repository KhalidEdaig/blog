<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('title');
      $table->string('slug');
      $table->text('body');
      $table->string('image');
      $table->boolean('published')->default(0);
      $table->uuid('category_id')->nullable();
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
      $table->uuid('user_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('posts');
  }
}
