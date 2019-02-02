<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => "required|alpha",
            "email" => "required|email|unique:users",
            "username" => [
                "required",
                "min:8",
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', $value)) {
                        $fail($attribute . '  has to be a combination of letters and numbers');
                    }
                },
            ],
            "password" => [
                "required",
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            "image" => "required|image",
            "age" => "required",
            "biography" => "required|min:10",
        ];
    }
}
