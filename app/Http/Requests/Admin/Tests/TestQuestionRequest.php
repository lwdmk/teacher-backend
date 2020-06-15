<?php

namespace App\Http\Requests\Admin\Tests;

use Illuminate\Foundation\Http\FormRequest;

class TestQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'test_id' => 'required|integer|exists:test,id',
//            'title' => 'required|string',
//            'type' => 'required|integer',
        ];
    }
}
