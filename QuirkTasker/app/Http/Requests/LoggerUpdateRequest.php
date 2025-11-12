<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoggerUpdateRequest extends FormRequest
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
            'user_id' => 'somtimes|integer|exists:users,id',
            'task_id' => 'sometimes|integer|exists:tasks,id',
            'action' => 'required|in:completed,not completed,in progress'
        ];
    }
}
