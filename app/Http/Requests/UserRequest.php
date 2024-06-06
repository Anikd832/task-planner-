<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'contact' => $this->contact,
            'password' => bcrypt($this->password),
            'status' => $this->status ?? 1
        ];
    }
}
