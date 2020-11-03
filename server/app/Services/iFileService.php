<?php

namespace App\Services;

use App;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;

use App\Services\AuthService;
use App\Repositories\UserRepository;
use App\Repositories\FileRepository;

interface iFileService
{
    public function index(FileRepository $fileRepository) :array;

    public function userIndex(AuthService $authService, FileRepository $fileRepository) :array;
    
    public function store(FileRequest $request, AuthService $authService, FileRepository $fileRepository) :array;

    public function update(int $id, FileRequest $request, FileRepository $fileRepository) :array;   
      
    public function delete(int $id, FileRepository $fileRepository) :array;
}