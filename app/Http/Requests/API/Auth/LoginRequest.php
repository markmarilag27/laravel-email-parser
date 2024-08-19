<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'max:255'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->max(255),
            ],
        ];
    }
}
