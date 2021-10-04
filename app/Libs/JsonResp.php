<?php

namespace App\Libs;

use App\Enums\eRespCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class JsonResp extends Resp
{
    /**
     * @param $custom_code mandatory
     * @param $data mandatory
     * @param string $message optional
     * @return $this
     */
    public function ok(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_ok($data);
    }
    /**
     * @param $custom_code mandatory
     * @param $data mandatory
     * @param string $message optional
     * @return $this
     */
    public function created(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_created($data);
    }
    /**
     * @param $custom_code mandatory
     * @param $data mandatory
     * @param string $message optional
     * @return $this
     */
    public function accepted(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_created($data);
    }
    /**
     * @param $data optional
     * @param string $message optional
     * @return $this
     */
    public function bad_request($data=null) : JsonResponse{
        if($data instanceof Validator){
            $data = $data->errors()->getMessages();
            $data = collect($data)->map(function ($item, $key) {
                return implode(',',$item);
            })->toArray();
        }
        self::setResponseCode($data,eRespCode::_400_BAD_REQUEST);
        return self::_bad_request($data);
    }
    /** NOT FOUND
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function not_found(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_not_found($data);
    }
    /** UNAUTHORIZED
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function unauthorized(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_unauthorized($data);
    }
    /** FORBIDDEN
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function forbidden(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_forbidden($data);
    }
    /** NOT ACCEPTABLE
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function not_acceptable(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_not_acceptable($data);
    }
    /** INTERNAL ERROR
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function internal_error($data=null) : JsonResponse{
        self::setResponseCode($data,eRespCode::_500_INTERNAL_ERROR);
        return self::_internal_error($data);
    }
    /** UNKNOWN ERROR
     * @param null $data optional
     * @param string $message message for user
     * @return $this
     */
    public function unknown_error($data=null)  : JsonResponse{
        self::setResponseCode($data,eRespCode::_520_UNKNOWN_ERROR);
        return self::_unknown_error($data);
    }
    /**
     * @param $data optional
     * @param string $message optional
     * @return $this
     */
    public function custom_bad_request(array $eRespCode,$data=null) : JsonResponse{
        self::setResponseCode($data,$eRespCode);
        return self::_bad_request($data);
    }

    public function guessResponse($response){
        $code = substr(explode('_', array_keys($response)[0])[0], -3);
        switch ($code){
            case '400':
                return $this->custom_bad_request($response);
                break;
            case '403':
                return $this->forbidden($response);
                break;
            case '404':
                return $this->not_found($response);
                break;
            case '500':
                return $this->internal_error($response);
                break;
            default:
                return $this->internal_error($response);
                break;
        }
    }
}
