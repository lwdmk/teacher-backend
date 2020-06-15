<?php

namespace App\Http\Requests\Admin\Users;

use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    /**
     * @return bool
     */
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
            'name' => 'required|string|max:255',
            'role' =>  ['required', 'string', Rule::in(array_keys(User::rolesList()))],
        ];

        if ($this->has('role')) {
            if ($this->get('role') === User::ROLE_ADMIN) {
                $rules['email'] = 'required|string|email|max:255|unique:users';
                $rules['password'] = 'required|string|min:8';
            } elseif ($this->get('role') === User::ROLE_USER) {
                $rules['grade'] = ['required', 'integer', Rule::in(array_keys(User::gradeList()))];
                $rules['grade_letter'] = ['required', 'string', Rule::in(array_keys(User::gradeLetterList()))];
                $rules['access_code'] = 'required|integer|unique:users';
            }
        }
        return $rules;
    }
}
