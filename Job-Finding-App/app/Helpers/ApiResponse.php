<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class ApiResponse
{
     protected array|Collection $data = [];
     protected int $code = 200;
     protected string $message = "";
    public function success($data=null, $message=null, $code=200){
        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ]);
    }
    public function error( $message,$data=null, $code=500){
        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ]);
    }

}
