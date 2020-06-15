<?php

namespace App\Http\Requests\Api\Tests;

use App\Entity\Test\Test;
use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StartTestRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'hash' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string'
        ];
    }
}
