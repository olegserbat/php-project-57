<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
        $uniq = Rule::unique('tasks');
        if ($this->route('id')) {
            $uniq = $uniq->ignore($this->route('id'));
        }
        return [
            'name' => [
                'required',
                $uniq,
                'max:255',
                'string',
            ],
            'status_id' => 'required|integer',
            'description' => 'nullable|max:255|string',
            'assigned_to_id' => 'nullable|integer',
            'labels' => 'nullable|array',
            'labels.*' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Задача с таким именем уже существует',
        ];
    }
}
