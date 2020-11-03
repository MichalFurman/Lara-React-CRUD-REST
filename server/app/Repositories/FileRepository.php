<?php

  namespace App\Repositories;

  use App;
  use App\Models\FileUpload;
  use App\Services\FileService;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;


  class FileRepository implements iFileRepository {
    
    private $authService;
    private $fileModel;

    function __construct(FileUpload $fileModel) {
      $this->fileModel = $fileModel;
    }

    // niewykorzystana 
    public function validationToString($errArray) : string {
      $valArr = array();
      foreach ($errArray->toArray() as $key => $value) { 
          $errStr = $value[0];
          array_push($valArr, $errStr);
      }
      if(!empty($valArr)){
          $errString = implode('</br>', $valArr);
      }
      return $errString;
    }

    // niewykorzystana 
    public function valid(Request $request) {
     
      $request_data = $request->json()->all();
      return Validator::make($request_data,[
          'name' => 'required|string|max:256',
      ]);
    }

    public function index() : array {  
      try {
        $data = $this->fileModel->allFiles()->get();
        return array('message'=>'files_index','data'=>$data, 'code'=>200);
      }  
      catch (Exception $e){
        return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

    public function userIndex($user_id) : array {       
      try {
        $data = $this->fileModel->allFiles()->where('user_id','=',$user_id)->get();
          return array('message'=>'userfiles_index','data'=>$data,'code'=>200);
      }
      catch (Exception $e){
          return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

    public function store(array $data, int $user_id) : array {
      
      try {   
        $this->fileModel->user_id = $user_id;
        $this->fileModel->name = $data['name'];
        $this->fileModel->file = $data['filename'];
        $this->fileModel->path = $data['uri'];
        $this->fileModel->save();

        return array('message' => 'upload_success', 'code'=>201);
      }
      catch (Exception $e){
        return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }
    
    public function update(int $id, string $name) : array {
      try {
        $file = $this->fileModel->findOrFail($id);
        $file->name = $name;
        $file->save();
        return array('message' => 'update_success', 'code'=>201);
      }
      catch (Exception $e){
        return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

    public function findOrFail($id){
      return $this->fileModel->findOrFail($id);
    }

    public function destroy($id){
      return $this->fileModel->destroy($id);
    }

  }