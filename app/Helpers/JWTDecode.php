<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class JWTDecode extends Controller
{
    private $publicKey;

    public function __construct($dir)
    {
        if ($this->publicKey === null) {
            $this->publicKey = openssl_pkey_get_public("file://" . $dir . '/public_key.pem');
        }
    }

    public function verifyToken($jwtToken)
    {
        try {
            return JWT::decode($jwtToken, new Key($this->publicKey, 'RS256'));
        } catch (\Exception $e) {
            throw new \Exception('Token verification failed: ' . $e->getMessage());
        }
    }
}
