<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        return [
            "company" => "required",
            "position" => "required",
            "salary" => "numeric|nullable",
            "province" => "required",
            "district" => "required",
            "street" => "nullable",
            "email" => "nullable|email",
            'phone' => "nullable|numeric|digits_between:9,14", 
            'duedate' => 'required|date',
        ];
    }
}
