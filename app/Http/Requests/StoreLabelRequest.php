<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabelRequest extends FormRequest
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
            'name' => [
                'required',
                'unique:App\Models\Label,name',
                'max:255',
                'string'
            ],
            'description' => 'nullable|max:255|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Метка с таким именем уже существует',
        ];
    }
}
