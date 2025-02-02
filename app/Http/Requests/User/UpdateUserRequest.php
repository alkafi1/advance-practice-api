<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
            'status'   => 'nullable|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.email'    => 'Provide a valid email address.',
            'email.unique'   => 'This email is already in use.',
            'password.min'   => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'status.in'      => 'Invalid status value.',
        ];
    }
}
