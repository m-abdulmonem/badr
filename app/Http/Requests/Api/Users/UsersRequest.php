<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'f_name' => ['required', 'string'],
            'm_name' => ['nullable', 'string'],
            'drive_license' => ['nullable', 'string'],
            'l_name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'regex:/^01[0125][0-9]{8}$/'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email"],
            'password' => [($this->id ? 'nullable' : 'required'), 'string', 'min:8', 'confirmed'],
        ];
    }
}
