<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    protected $errorBag = 'registerForm';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|emailblacklist',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required',
            'email.required' => 'The email field is required',
            'password.required' => 'The password field is required',
        ];
    }
}
