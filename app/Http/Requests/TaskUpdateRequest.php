<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
                // Unique validation rule, but ignore the current task being edited
                'unique:tasks,title,' . $this->route('task')->id,
            ],
            'content' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'in:to_do,in_progress,done', // Ensures the status is one of the valid options
            ],
            'user_id' => [
                'required',
                'exists:users,id', // Ensures that user_id exists in the users table
            ],
            'published_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The task title is required.',
            'title.unique' => 'The task title must be unique.',
            'title.max' => 'The task title may not be greater than 100 characters.',
            'content.required' => 'The task content is required.',
            'status.required' => 'The task status is required.',
            'status.in' => 'The task status must be one of the following: to_do, in_progress, or done.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The specified user ID does not exist.',
        ];
    }
}
