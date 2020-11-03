<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\UserController;
use App\Services\AuthService;
use App\Services\FileService;
use App\Repositories\FileRepository;

class FileUploadController extends Controller
{
    function __construct() {
        $this->middleware('JWTMiddleware');
        // App::setLocale('pl');
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FileService $fileService, FileRepository $fileRepository) {
        $result = $fileService->index($fileRepository);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message'], 'files' => $result['data']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    public function userIndex(FileService $fileService, FileRepository $fileRepository, AuthService $authService) {
        $result = $fileService->userIndex($authService, $fileRepository);
        // var_dump($result);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message'], 'files' => $result['data']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request, FileService $fileService, fileRepository $fileRepository, AuthService $authService) {
      
        $result = $fileService->store($request, $authService, $fileRepository);
        if ($result['code'] === 201) 
            return response()->json(['message' => $result['message'],'uri'=>$result['data']['uri'], 'filename'=>$result['data']['filename'], 'name'=>$result['data']['name'], 'user_id'=>$result['data']['user_id']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, FileRequest $request, FileService $fileService, FileRepository $fileRepository)
    {
        $result = $fileService->update($id, $request, $fileRepository);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, Request $request, FileService $fileService, FileRepository $fileRepository)
    {
        $result = $fileService->delete($id, $fileRepository);
        if ($result['code'] === 200) 
            return response()->json(['message' => $result['message']],$result['code']);
        else
            return response()->json(['message' => $result['message']],$result['code']);
    }
}
