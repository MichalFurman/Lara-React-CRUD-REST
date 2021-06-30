<?php

namespace App\Http\Controllers;

use App;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;


class AuthController extends Controller
{
    function __construct() {
    }
   
    public function login(Request $request, AuthService $authService) 
    {
        $result = $authService->login($request);
        if ($result['code'] === 200) 
            return response()->json(['token' => $result['token'], 'secret' => $result['secret']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    
    public function logout(Request $request, AuthService $authService) 
    {
        $result = $authService->logout($request);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    
    public function getAuthenticatedUser(Request $request, AuthService $authService) 
    {
        $result =  $authService->authJWTUser($request);
        if ($result['code'] === 200) 
            return response()->json(['user' => $result['user']],$result['code']);
        else 
            return response()->json(['message' => $result['message']],$result['code']);
    }

    
    public function checkAuthenticatedUser(Request $request, AuthService $authService) 
    {
        $result =  $authService->authJWTUser($request);
        if ($result['code'] === 200) 
            return response()->json(['user' => $result['user']],$result['code']);
        else 
            return response()->json(['message' => $result['message']],$result['code']);
    }

}
