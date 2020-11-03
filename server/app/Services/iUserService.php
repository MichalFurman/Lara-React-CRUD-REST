<?php

namespace App\Services;

use App;
use Illuminate\Http\Request;
use App\Services\iAuthService;
use App\Repositories\iUserRepository;
use App\Http\Requests\UserRequest;

interface iUserService
{
    public function register(UserRequest $request, iUserRepository $userRepository, iAuthService $authService) :array;

    public function create(UserRequest $request, iUserRepository $userRepository) :array;

    public function editProfile(UserRequest $request, iUserRepository $userRepository, iAuthService $authService) :array;
}