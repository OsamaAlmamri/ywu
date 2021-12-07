<?php

namespace App\Traits;


trait JsonTrait
{
    private $headers = ['Content-Type' => 'application/json; charset=UTF-8','charset' => 'utf-8'];

    public function ReturnErorrRespons($errNum, $msg)
    {

        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg,
        ],200,$this->headers, JSON_UNESCAPED_UNICODE);
    }

    public function ReturnSuccessRespons($errNum = "200", $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg,
        ],200,$this->headers, JSON_UNESCAPED_UNICODE);
    }

    public function GetDateResponse($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => '200',
            'msg' => $msg,
            $key => $value,
        ],200,$this->headers, JSON_UNESCAPED_UNICODE);
    }

    #################################### validat
    public function returnValidationError($code = "E001", $validator=null)
    {
        return $this->ReturnErorrRespons($code,($validator!=null)? $validator->errors()->first():"");
    }


    public function returnCodeAccordingToInput($validator)
    {

        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E0011';
        else if ($input == "email")
            return 'E003';
        else if ($input == "password")
            return 'E002';
        else
            return "0000";
    }

}
