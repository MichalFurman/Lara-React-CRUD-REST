<?php

  namespace App\Repositories;

  use App;
  use App\Models\FileUpload;
  use App\Services\FileService;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;


  interface iFileRepository {
    
    public function index() : array;

    public function userIndex($user_id) : array;

    public function store(array $data, int $user_id) : array;
    
    public function update(int $id, string $name) : array;

  }