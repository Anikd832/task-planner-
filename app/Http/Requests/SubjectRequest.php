<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'title' => 'required',
            'code' => 'sometimes',
            'credit' => 'required',
            'subject_type' => 'required',
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return [
            'title' => $this->title,
            'code' => $this->code,
            'credit' => $this->credit,
            'subject_type' => $this->subject_type
        ];
    }

    /**
     * persist form data
     */
    public function persistUpdate($task): array
    {
        return [
            'title' => $this->title,
            'code' => $this->code,
            'credit' => $this->credit,
            'subject_type' => $this->subject_type
        ];
    }
}
