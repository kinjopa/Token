<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use App\Http\Controllers\Controller;

class JWTGenerator extends Controller
{
    private $privateKey;

    public function __construct($dir)
    {
        if ($this->privateKey === null) {
            $this->privateKey = openssl_pkey_get_private("file://" . $dir . '/private_key.pem');
        }
    }

    public function generateToken()
    {
        $payload = [
            'data' => 'magic'
        ];

        try {
            return JWT::encode($payload, $this->privateKey, 'RS256');
        } catch (\Exception $e) {
            throw new \Exception('Token creation failed: ' . $e->getMessage());
        }
    }

}
