<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    private $mailRules = '';
    private $authService;
    public $validator;

    function __construct(AuthService $authService) {
        $this->authService = $authService;
    }


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
    

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();
        if ($this->get('_method', null) !== null) {
            $method = $this->get('_method');
        }
        // $this->offsetUnset('_method');
        switch ($method) {
            case 'DELETE':
            case 'GET':
                break;   
            case 'POST':
                    $mailRules = \Config::get('database.default').'.users';
                break;
            case 'PUT':
                    $user = $this->authService->authJWTUserForm();
                    $mailRules = \Config::get('database.default').'.users,email,'.$user->getKey();
                break;
            case 'PATCH':
                break;
            default:
                break;
        }
        
        return [
            'name' => 'required|string|max:256',
            'email' => 'required|string|email|max:255|unique:'.$mailRules,
            'password' => 'required|string|min:3',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $this->validator = $validator;
    }
}
