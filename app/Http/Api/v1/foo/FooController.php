<?php

namespace App\Http\Api\v1\foo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FooController extends Controller
{
    public function handleRequest(Request $request)
    {
        $authHeader = $request->header('Authorization');

        $storage_dir = storage_path('keys');
        $jwtGenerator = new \App\Helpers\JWTGenerator($storage_dir);

        $jwtToken = str_replace('Bearer ', '', $authHeader);


        $isValidToken = $jwtGenerator->verifyToken($jwtToken);

        if ($isValidToken) {
            http_response_code(200);
            echo "OK";
        } else {
            http_response_code(401);
            echo "Unauthorized";
        }
    }
}
