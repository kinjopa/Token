<?php

namespace App\Http\Controllers;

use Httpful\Request;

class MainController extends Controller
{

    public function index()
    {
        $storage_dir = storage_path('keys');

        $jwtGenerator = new \App\Helpers\JWTGenerator($storage_dir);
        $token = $jwtGenerator->generateToken();

        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer $token",
        ];

        $url = "http://my_laravel_app_nginx:8081/api/v1/foo";

        $start = microtime(true);

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]);
            $response = curl_exec($curl);
            curl_close($curl);

            $end = microtime(true);

            if ($response) {
                $timeTaken = round(($end - $start), 4);
                echo "Затраченное время: {$timeTaken} секунд. " . $response;
            } else {
                echo "Ошибка при выполнении запроса";
            }
        } catch (\Exception $e) {
            echo "Произошла ошибка: " . $e->getMessage();
        }
    }
}
