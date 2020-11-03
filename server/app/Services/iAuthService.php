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


interface iAuthService
{
    public function authJWToken (Request $request) :array;

    public function authJWTUser (Request $request);

    public function authJWTUserForm ();

    public function login(Request $request) : array;

    public function logout(Request $request) : array;

    public function AuthenticatedUser(Request $request);

    public function getToken(User $user);
}
