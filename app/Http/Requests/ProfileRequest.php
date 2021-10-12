<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            // 'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
            'street' => 'required', 
            'province' => 'required', 
            'gender' => 'required', 
            'address' => 'required', 
            'sub_district' => 'required', 
            'district' => 'required', 
            'pob' => 'required|alpha', 
            'dob' => 'required|date', 
            'department' => 'required', 
            'grad' => 'required|numeric|digits:4', 
            'phone' => 'required|numeric|digits_between:9,14', 
        ];
    }
}
