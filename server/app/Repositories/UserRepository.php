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


  class UserRepository implements iUserRepository {
  
    private $authService;

    function __construct(AuthService $authService) {
      $this->authService = $authService;
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
      if ($request->isMethod('PUT')) {
          $user = $this->authService->authJWTUserForm();
          $mailRules = \Config::get('database.default').'.users,email,'.$user->getKey();
      }
      else $mailRules = \Config::get('database.default').'.users';
      
      $request_data = $request->json()->all();
      return Validator::make($request_data,[
          'name' => 'required|string|max:256',
          'email' => 'required|string|email|max:255|unique:'.$mailRules,
          'password' => 'required|string|min:3',
      ]);
    }

    public function register(UserRequest $request) :array {  
      try {
          $user = User::create([
            'name' => $request->json()->get('name'),
            'email' => $request->json()->get('email'),
            'password' => Hash::make($request->json()->get('password')),
            'role' => "user"
          ]);
        return array('message'=>'user_registered','data'=>$user, 'code'=>201);
      }  
      catch (Exception $e){
        return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

    public function create(UserRequest $request) : array {       
      try {
          $user = User::create([
              'name' => $request->json()->get('name'),
              'email' => $request->json()->get('email'),
              'password' => Hash::make($request->json()->get('password')),
              'role' => $request->json()->get('role'),
          ]);
          return array('message'=>'user_created','data'=>$user,'code'=>201);
      }
      catch (Exception $e){
          return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

    public function editProfile(UserRequest $request,User $user) : array {       
      try {
        $user->name = $request->json()->get('name');
        $user->email = $request->json()->get('email');
        $user->password = Hash::make($request->json()->get('password'));
        ($request->json()->get('role') !== 'old') ? $user->role = $request->json()->get('role') : null;
        $user->save();
        if ($request->json()->get('role') == 'old') return array('message'=>'profile_edited','code'=>200);
        else return array('message'=>'credentials_changed','code'=>200);
      }
      catch (Exception $e){
          return array('message' =>$e->getMessage(),'code'=>400);
      } 
    }

  }