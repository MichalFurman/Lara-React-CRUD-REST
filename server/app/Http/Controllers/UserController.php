<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use App\Repositories\UserRepository;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function __construct() {
        $this->middleware('JWTMiddleware');
    }
   
    public function register(UserRequest $request, UserService $userService, UserRepository $userRepository, AuthService $authService) {

        $result = $userService->register($request, $userRepository, $authService);
        if ($result['code'] === 201) 
            return response()->json(['message' => $result['message'], 'user' => $result['data'], 'token' => $result['token']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    public function addUser(UserRequest $request, UserService $userService, UserRepository $userRepository) {
        
        $result = $userService->create($request, $userRepository);
        if ($result['code'] === 201) 
            return response()->json(['message' => $result['message'], 'user' => $result['data']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    public function editProfile(UserRequest $request, UserService $userService, UserRepository $userRepository, AuthService $authService) {
        $result = $userService->editProfile($request, $userRepository, $authService);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message']],$result['code']);
        else 
            return response()->json(['message' => $result['message']],$result['code']);
    }

}
