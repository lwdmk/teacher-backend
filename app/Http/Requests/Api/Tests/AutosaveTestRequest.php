<?php

namespace App\Http\Requests\Api\Tests;

use App\Entity\Test\Test;
use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AutosaveTestRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'data' => 'required|json'
        ];
    }
}
