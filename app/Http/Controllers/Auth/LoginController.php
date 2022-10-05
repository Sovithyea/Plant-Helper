<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $data = $response->json();

        return response()->json($data, $response->getStatusCode());
    }

    public function refresh(RefreshTokenRequest $request)
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'refresh_token' => $request->refresh_token,
        ]);

        $data = $response->json();

        return response()->json($data, $response->getStatusCode());
    }

    // public function login(LoginRequest $request)
    // {
    //     $response = Http::asForm()->post('http://localhost:8001/oauth/token', [
    //         'grant_type' => 'password',
    //         'client_id' => env('CLIENT_ID'),
    //         'client_secret' => env('CLIENT_SECRET'),
    //         'username' => $request->username,
    //         'password' => $request->password,
    //     ]);

    //     $data = $response->json();

    //     return response()->json($data, $response->getStatusCode());
    // }

    // public function refresh(RefreshTokenRequest $request)
    // {
    //     $response = Http::asForm()->post('http://localhost:8001/oauth/token', [
    //         'grant_type' => 'refresh_token',
    //         'client_id' => env('CLIENT_ID'),
    //         'client_secret' => env('CLIENT_SECRET'),
    //         'refresh_token' => $request->refresh_token,
    //     ]);

    //     $data = $response->json();

    //     return response()->json($data, $response->getStatusCode());
    // }
}
