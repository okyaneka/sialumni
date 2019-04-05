<?php

namespace App\Http\Requests;

use App\Department;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'code' => [
                'required', Rule::unique((new Department)->getTable())->ignore($this->route()->department ?? null)
            ],
            'department' => [
                'required'
            ],
        ];
    }
}
