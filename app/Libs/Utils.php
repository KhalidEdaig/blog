<?php

namespace App\Libs;

use App\StoreSettings;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Utils
{


  public static function getRandomString($length = 3)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
  }

  public static function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
  {
    $name = !is_null($filename) ? $filename : Str::random(25);
    $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->extension(), $disk);
    return $file;
  }
}
