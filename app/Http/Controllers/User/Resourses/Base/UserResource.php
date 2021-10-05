<?php

namespace App\Http\Controllers\User\Resourses\Base;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'username' => $this->username,
      'email' => $this->email,
      'is_active' => $this->active,
      'role' =>  $this->getRoleNames()[0],
      'perms' => $this->getPermissionNames(),
      'created_at' => Carbon::parse($this->created_at)->toDateTimeString()
    ];
  }
}
