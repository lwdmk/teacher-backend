<?php

namespace App\Http\Requests\Admin\Tests;

use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|integer',
            'duration' => 'required|integer',
            'description' => 'string|nullable'
        ];

        $rules['grade'] = ['required', 'integer', Rule::in(array_keys(User::gradeList()))];

        return $rules;
    }
}
