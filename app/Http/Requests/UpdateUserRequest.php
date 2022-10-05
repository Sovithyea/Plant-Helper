<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore(request('user')->id)],
            'email' => ['required', Rule::unique('users', 'email')->ignore(request('user')->id)],
            'role' => ['required', Rule::in(['admin', 'customer'])],
            'avatar' => ['nullable', 'image']
        ];
    }
}
