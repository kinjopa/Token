<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use App\Http\Controllers\Controller;
use Firebase\JWT\Key;

class JWTGenerator extends Controller
{
    private $privateKey;
    private $publicKey;

    public function __construct($dir)
    {
        $this->loadKeys($dir);
    }

    private function loadKeys($dir)
    {
        if ($this->privateKey === null) {
            $this->privateKey = openssl_pkey_get_private("file://" . $dir . '/private_key.pem');
        }

        if ($this->publicKey === null) {
            $this->publicKey = openssl_pkey_get_public("file://" . $dir . '/public_key.pem');
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

    public function verifyToken($jwtToken)
    {
        try {
            return JWT::decode($jwtToken, new Key($this->publicKey, 'RS256'));
        } catch (\Exception $e) {
            throw new \Exception('Token verification failed: ' . $e->getMessage());
        }
    }
}
