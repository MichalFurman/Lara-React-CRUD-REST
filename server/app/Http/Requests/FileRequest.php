<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class FileRequest extends FormRequest
{
    public $validator;
    public $rules = [];

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
        switch ($method) {
            case 'DELETE':
            case 'GET':
                break;   
            case 'POST':
                    $this->rules = [
                        'file'    => 'required|mimetypes:image/gif,image/jpeg,image/png,image/bmp|max:2000',
                    ];
                break;
            case 'PUT':
                    $this->rules = [
                        'name'      => 'required|string|max:128',
                    ];
            break;
            case 'PATCH':
                break;
            default:
                break;
        }
        return $this->rules;
    }

    public function messages() {
        return [
            'contact_details.required' => 'At least one method of contact is required for your advert.',
            'file.required' => 'Please choose file to upload',
            'file.max' => 'Your file is too large, maximum accepted size is 2000 kB',
        ];
    }
    protected function failedValidation(Validator $validator) {
        $this->validator = $validator;
    }

}
