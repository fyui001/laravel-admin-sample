<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request as AppRequest;

class LoginRequest extends AppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|max:255',
            'password' => 'required|max:255',
        ];
    }
}
