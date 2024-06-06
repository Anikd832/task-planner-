<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutineRequest extends FormRequest
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
            'room_no' => 'required',
            'from' => 'required',
            'to' => 'required',
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return [

            'user_id' => auth()->user()->id,
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->teacher_id,
            'day_id' => $this->day_id,
            'room_no' => $this->room_no,
            'from' => $this->from,
            'to' => $this->to,
            'status' => $this->status ?? 1
        ];
    }

    /**
     * persist form data
     */
}
