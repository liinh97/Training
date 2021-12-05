<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class handleAnwser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
        // dd(FormRequest::all());
        $listRequire = FormRequest::all()['require-validate'];
        $rule = [];
        foreach($listRequire as $value){
            $rule['qq'.$value] = 'required';
        }
        // dd($rule);
        return $rule;
    }

    public function messages()
    {
        $listRequire = FormRequest::all()['require-validate'];
        $mess = [];
        foreach($listRequire as $value){
            $mess['qq'.$value . '.required'] = 'This field is required.';
        }
        // dd($mess);
        return $mess;
    }
}
