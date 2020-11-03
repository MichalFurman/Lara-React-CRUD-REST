<?php

  namespace App\Repositories;

  use App;
  use App\Models\User;
  use App\Services\UserService;
  use App\Services\AuthService;

  use Illuminate\Http\Request;
  use App\Http\Requests\UserRequest;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;


  interface iUserRepository {
  
    public function register(UserRequest $request) :array;

    public function create(UserRequest $request) : array;

    public function editProfile(UserRequest $request,User $user) : array;

  }