<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nisn' => ['required', 'min:4'],
            'name' => ['required', 'min:3'],
            'email' => ['nullable', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)],
            'dob' => ['required', 'date', 'before:' . date('Y-m-d', strtotime('-15 years'))],
            'pob' => ['nullable', 'string', 'regex:/^[a-zA-Z\s]*$/'],
            'department_slug' => ['nullable']
        ];
    }
}
