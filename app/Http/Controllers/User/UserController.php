<?php

namespace App\Http\Controllers\User;

use App\Enums\eRespCode;
use App\Http\Controllers\ResponseController;

use App\Http\Controllers\User\Resourses\Base\UserResourceCollection;
use App\Models\User;

class UserController extends ResponseController
{
  public function all()
  {
    return $this->resp->ok(eRespCode::U_LISTED_200_00, new UserResourceCollection(User::where('id', '!=', \auth()->user()->id)->get()));
  }
}
