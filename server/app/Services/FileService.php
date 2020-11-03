<?php

namespace App\Services;

use App;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;

use App\Services\iAuthService;
use App\Repositories\iUserRepository;
use App\Repositories\iFileRepository;

class FileService implements iFileService
{
    function __construct() {
    }


    public function index(iFileRepository $fileRepository) :array {
      $result = $fileRepository->index();
      if ($result['code'] === 200)
          return array('message' =>$result['message'], 'data'=>$result['data'], 'code'=>$result['code']);
      else
          return array('message'=>$result['message'], 'code'=>$result['code']);   
    }

    public function userIndex(iAuthService $authService, iFileRepository $fileRepository) :array {
      $user = $authService->authJWTUserForm();
      if ($user->getKey() !== null) {
        $result = $fileRepository->userIndex($user->getKey());
        if ($result['code'] === 200)
            return array('message' =>$result['message'], 'data'=>$result['data'], 'code'=>$result['code']);
        else
            return array('message'=>$result['message'], 'code'=>$result['code']);        
      }
      else return response()->json(['message' => 'bad user'],400);
    }
    
    public function store(FileRequest $request, iAuthService $authService, iFileRepository $fileRepository) :array {
      if ($request->validator->fails()) return array('message'=>$request->validationToString($request->validator->errors()), 'code'=>422);
      
      $user = $authService->authJWTUserForm();
      if($request->file('file') && $user->getKey() !== null) {
        $file = $request->file('file');
     
        $name = $request->file->getClientOriginalName();   
        $filename = time().'.'.$request->file->extension();
        $uri = url('/uploads/').'/'.$filename;

        try {
          \Image::make($request->file('file'))
          ->resize(450, 450, function ($constraint) {
            $constraint->aspectRatio();
          })
          ->save(public_path('uploads\\').$filename);  
        }
        catch (Exception $e){
          return array('message' =>$e->getMessage(),'code'=>400);
        } 
        
        $data = array('name' => $name, 'filename' => $filename, 'uri' => $uri, 'user_id' => $user->getKey());
        
        $result = $fileRepository->store($data, $user->getKey());
        if ($result['code'] === 201)
            return array('message' =>$result['message'], 'data'=>$data, 'code'=>$result['code']);
        else
            return array('message'=>$result['message'], 'code'=>$result['code']);   
        
      }
      else return array('message' => 'empty_file', 'code' => 422);
    }

    public function update(int $id, FileRequest $request, iFileRepository $fileRepository) :array{
      // $validator =  $fileRepository->valid($request);
      if ($request->validator->fails()) return array('message'=>$request->validationToString($request->validator->errors()), 'code'=>422);

      $result = $fileRepository->update($id, $request->get('name'));
      if ($result['code'] === 200)
          return array('message' =>$result['message'], 'code'=>$result['code']);
      else
          return array('message'=>$result['message'], 'code'=>$result['code']);        
    }
      
      
    public function delete(int $id, iFileRepository $fileRepository) :array {
      try{
        $file = $fileRepository->findOrFail($id);
        $filename = public_path('uploads\\').$file->file;
        if (file_exists($filename)) unlink($filename);
        $file = $fileRepository->destroy($id);
        return array('message'=>'delete_success', 'code'=>200);   

      } catch (\Exception $e) {
        return array('message'=> $e, 'code'=>400);   
      }
    }  
  
}