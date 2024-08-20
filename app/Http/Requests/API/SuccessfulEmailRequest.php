<?php

declare(strict_types=1);

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SuccessfulEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'affiliate_id' => ['required', 'integer'],
            'envelope' => ['required', 'string'],
            'from' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string'],
            'dkim' => ['nullable', 'string', 'max:255'],
            'SPF' => ['required', 'string', 'max:255'],
            'spam_score' => ['nullable', 'numeric'],
            'email' => ['required', 'string'],
            'raw_text' => ['nullable', 'string'],
            'sender_ip' => ['nullable', 'string', 'max:50'],
            'to' => ['required', 'string'],
        ];
    }
}
