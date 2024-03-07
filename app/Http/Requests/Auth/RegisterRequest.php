<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'name' => 'required|string',
            'telegramm' => 'required|string',
            'source_name' => 'required|string',
            'from' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Поле не может быть пустым',
            'email.email' => 'Вы ввели email некорректно',
            'password.required' => 'Поле не может быть пустым',
            'name.required' => 'Поле не может быть пустым',
            'telegramm.required' => 'Поле не может быть пустым',
            'source_name.required' => 'Поле не может быть пустым',
            'from.required' => 'Поле не может быть пустым',
        ];
    }

    public function getName(): string
    {
        return $this->input('name');
    }
    public function getSourceName(): string
    {
        return $this->input('source_name');
    }
    public function getEmail(): string
    {
        return $this->input('email');
    }
    public function getPassword(): string
    {
        return $this->input('password');
    }
    public function getTelegramm(): string
    {
        return $this->input('telegramm');
    }
    public function getFrom(): string
    {
        return $this->input('from');
    }

}
