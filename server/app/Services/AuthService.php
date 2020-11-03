<?php

namespace App\Services;

use App;

use Illuminate\Http\Request;
// use Illuminate\Foundation\Http\FormRequest;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;


class AuthService implements iAuthService
{
    function __construct() {
    }

    private $secret = '12345';
    
    public function authJWToken (Request $request) :array{
        try {
            $token= str_replace('Bearer ', "" , $request->header('Authorization'));
            
            if (!JWTAuth::setToken($token)) // <-- Check token by setting
                return array('message' => 'user_not_found', 'code' => 401);
            
            if (!$claim = JWTAuth::getPayload()) {
                return array('message' => 'user_not_found', 'code' => 401);
            }
            if ($this->secret !== $request->header('Secret')){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return array('message' => 'user_logged', 'code' => 200);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }      
    }

    public function authJWTUser (Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            if ($this->secret !== $request->header('Secret')){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return $user;
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }      
    }


    public function authJWTUserForm (){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return $user;
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }      
    }

    public function login(Request $request) : array {
        $credentials = $request->json()->all();
        $secret =  $this->secret;

        try {
            if (!$token = JWTAuth::attempt($credentials)){
                return array('message' => 'invalid_credentials','code' =>401);
            }
        }
        catch (JWTException $e){
            return array('message' => 'could_not_create_token','code' =>500);
        }
        return array('token'=>$token, 'secret'=>$secret, 'code'=>200);
    }

    public function logout(Request $request) : array {
        $credentials = $request->json()->all();

        try {
            if (!$token = JWTAuth::attempt($credentials)){
                return array('message' => 'invalid_credentials','code' =>401);
            }
            JWTAuth::invalidate($token);
        }
        catch (JWTException $e){
            return array('message' => 'could_not_create_token','code' =>500);
        }
        return array('message'=>'logout_successful', 'code'=>200);
    }

    public function AuthenticatedUser(Request $request) {
        $user = $this->authJWTUser($request);
        return $user;
    }

    public function getToken(User $user) {
        return JWTAuth::fromUser($user);
    }
}
