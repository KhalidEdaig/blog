<?php

namespace App\Libs;

use \Illuminate\Http\JsonResponse;

class Resp
{
  const OK = 200;
  const CREATED = 201;
  const ACCEPTED = 202;
  const BAD_REQUEST = 400;
  const UNAUTHORIZED = 401;
  const FORBIDDEN = 403;
  const NOT_FOUND = 404;
  const NOT_ACCEPTABLE = 406;
  const INTERNAL_ERROR = 500;
  const UNKNOWN_ERROR = 520;

  private static function base($http_code, $data): JsonResponse
  {
    return response()->json($data)->header('Content-Type', 'application/json')->setStatusCode($http_code);
  }

  protected static function setResponseCode(&$data, array $eRespCode)
  {
    if (!empty($data)) {
      $data = ['data' => $data];
    }
    $key = array_keys($eRespCode)[0];
    $data['_response']['code'] = $key;
    $data['_response']['message'] = $eRespCode[$key];
  }

  protected static function _ok($data): JsonResponse
  {
    return self::base(self::OK, $data);
  }
  protected static function _created($data): JsonResponse
  {
    return self::base(self::CREATED, $data);
  }
  protected static function _accepted($data): JsonResponse
  {
    return self::base(self::ACCEPTED, $data);
  }
  protected static function _bad_request($data): JsonResponse
  {
    return self::base(self::BAD_REQUEST, $data);
  }
  protected static function _unauthorized($data): JsonResponse
  {
    return self::base(self::UNAUTHORIZED, $data);
  }
  protected static function _forbidden($data): JsonResponse
  {
    return self::base(self::FORBIDDEN, $data);
  }
  protected static function _not_found($data): JsonResponse
  {
    return self::base(self::NOT_FOUND, $data);
  }
  protected static function _not_acceptable($data): JsonResponse
  {
    return self::base(self::NOT_ACCEPTABLE, $data);
  }
  protected static function _internal_error($data): JsonResponse
  {
    return self::base(self::INTERNAL_ERROR, $data);
  }
  protected static function _unknown_error($data): JsonResponse
  {
    return self::base(self::UNKNOWN_ERROR, $data);
  }
}
