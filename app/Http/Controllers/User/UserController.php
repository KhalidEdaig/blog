<?php

namespace App\Http\Controllers\User;

use App\Enums\eRespCode;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\User\Resourses\Base\UserResource;
use App\Http\Controllers\User\Resourses\Base\UserResourceCollection;
use App\Models\User;


class UserController extends ResponseController
{
  public function all()
  {
    return $this->resp->ok(eRespCode::U_LISTED_200_00, new UserResourceCollection(User::where('id', '!=', \auth()->user()->id)->get()));
  }

  public function blockOrUnblock($userId)
  {
    $user = User::find($userId);
    $user->active = !$user->active;
    $user->save();
    return $this->resp->ok(eRespCode::P_UPDATED_200_01, new UserResource($user));
  }
}
