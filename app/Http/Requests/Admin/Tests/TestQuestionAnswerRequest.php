<?php

namespace App\Http\Requests\Admin\Tests;

use Illuminate\Foundation\Http\FormRequest;

class TestQuestionAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_id' => 'required|integer|exists:test_question,id',
            'answer.*.title' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
              'answer.*.title.required' => 'Необходимо задать ответ',
              'answer.*.title.string' => 'Ответ должен быть строкой',
              'answer.is_right.*.required'  => 'Необходимо выбрать правильный ответ',
              'answer.*.is_right.required'  => 'Необходимо задать верную поледовательность',
              'answer.*.is_right.int'  => 'Значение должно быть числом',

        ];
    }
}
