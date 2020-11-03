<?php

namespace App\Services;

use App;
use Illuminate\Http\Request;
use App\Services\iAuthService;
use App\Repositories\iUserRepository;
use App\Http\Requests\UserRequest;

class UserService implements iUserService
{
    function __construct() {
    }

    public function register(UserRequest $request, iUserRepository $userRepository, iAuthService $authService) :array {  
        // $validator =  $userRepository->valid($request);
        if ($request->validator->fails()) return array('message'=>$request->validationToString($request->validator->errors()), 'code'=>422);

        $result = $userRepository->register($request);
        if ($result['code'] === 201) {
            try {
                $token = $authService->getToken($result['data']);
                return array('message' =>$result['message'], 'token' =>$token, 'data'=>$result['data'], 'code'=>$result['code']);
            }
            catch (Exception $e) {
                return array('message'=>$e, 'code'=>400);
            }
        }
        else
            return array('message'=>$result['message'], 'code'=>$result['code']);   
    }

    public function create(UserRequest $request, iUserRepository $userRepository) :array {       
        // $validator =  $userRepository->valid($request);
        if ($request->validator->fails()) return array('message'=>$request->validationToString($request->validator->errors()), 'code'=>422);

        $result = $userRepository->create($request);
        if ($result['code'] === 201)
            return array('message' =>$result['message'], 'data'=>$result['data'], 'code'=>$result['code']);
        else
            return array('message'=>$result['message'], 'code'=>$result['code']);   
    }

    public function editProfile(UserRequest $request, iUserRepository $userRepository, iAuthService $authService) :array {       
        // $validator =  $userRepository->valid($request);
        if ($request->validator->fails()) return array('message'=>$request->validationToString($request->validator->errors()), 'code'=>422);

        $user = $authService->authJWTUserForm();
        $result = $userRepository->editProfile($request, $user);
        if ($result['code'] === 200)
            return array('message' =>$result['message'], 'code'=>$result['code']);
        else
            return array('message'=>$result['message'], 'code'=>$result['code']);   
    }
}