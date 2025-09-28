<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'comment' => 'required|max:255',
            'task_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'Поле комментариев при отправке не может быть пустым',
            'comment.max' => 'Комментариий должен быть короче 255 символов',
        ];
    }
}
