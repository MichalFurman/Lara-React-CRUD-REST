<?php

namespace App\Services;

use App;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

// use Tymon\JWTAuth\Facades\JWTFactory;
// use Tymon\JWTAuth\Contracts\JWTSubject;
// use Tymon\JWTAuth\PayloadFactory;
// use Tymon\JWTAuth\JWTManager as JWT;

use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService implements iAuthService
{
    function __construct() {
    }

    private $secret = '12345';
    

    public function authJWToken (Request $request) :array
    {
        try {
            $token= str_replace('Bearer ', "" , $request->header('Authorization'));
            
            if (!\JWTAuth::setToken($token)) // <-- Check token by setting
                return array('message' => 'user_not_found', 'code' => 401);
            
            if (!$claim = \JWTAuth::getPayload()) {
                return array('message' => 'user_not_found', 'code' => 401);
            }
            if ($this->secret !== $request->header('Secret')){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return array('message' => 'user_logged', 'code' => 200);
        }
        catch (TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }      
        catch (\Exception $e) {
            return array('message' => 'something_wrong', 'code' => 500);
        }      
    }


    public function authJWTUser (Request $request)
    {
        try {
            if (!$user = \JWTAuth::parseToken()->authenticate()){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            if ($this->secret !== $request->header('Secret')){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return array('user' =>$user, 'code' =>200);
        }
        catch (TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }
        catch (\Exception $e) {
            return array('message' => 'something_wrong', 'code' => 500);
        }      
    }


    public function authJWTUserForm ()
    {
        try {
            if (!$user = \JWTAuth::parseToken()->authenticate()){
                return array('message' => 'user_not_found', 'code' => 401);
            }
            return $user;
        }
        catch (TokenExpiredException $e) {
            return array('message' => 'token_expired', 'code' => 401);
        }
        catch (TokenInvalidException $e) {
            return array('message' => 'token_invalid', 'code' => 401);
        }
        catch (JWTException $e) {
            return array('message' => 'token_absent', 'code' => 401);
        }      
        catch (\Exception $e) {
            return array('message' => 'something_wrong', 'code' => 500);
        }      
    }


    public function login(Request $request) : array 
    {
        $credentials = $request->json()->all();
        $secret =  $this->secret;

        try {
            if (!$token = \JWTAuth::attempt($credentials)){
                return array('message' => 'invalid_credentials','code' =>401);
            }
        }
        catch (\ErrorException $e){
            return array('message' => 'invalid_credentials','code' =>401);
        }
        catch (QueryException $e){
            return array('message' => 'invalid_credentials','code' =>401);
        }
        catch (JWTException $e){
            return array('message' => 'could_not_create_token','code' =>500);
        }
        catch (\Exception $e) {
            return array('message' => 'something_wrong','code' => 500);
        }      
        return array('token'=>$token, 'secret'=>$secret, 'code'=>200);
    }


    public function logout(Request $request) : array 
    {
        $credentials = $request->json()->all();

        try {
            if (!$token = \JWTAuth::attempt($credentials)){
                return array('message' => 'invalid_credentials','code' =>401);
            }
            \JWTAuth::invalidate($token);
        }
        catch (JWTException $e){
            return array('message' => 'could_not_create_token','code' =>500);
        }
        catch (\Exception $e) {
            return array('message' => 'something_wrong', 'code' => 500);
        }      
        return array('message'=>'logout_successful', 'code'=>200);
    }


    public function AuthenticatedUser(Request $request) 
    {
        $user = $this->authJWTUser($request);
        return $user;
    }


    public function getToken(User $user) 
    {
        return \JWTAuth::fromUser($user);
    }
}
