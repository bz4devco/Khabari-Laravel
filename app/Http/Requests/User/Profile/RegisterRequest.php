<?php

namespace App\Http\Requests\User\Profile;

use App\Rules\NationalCode;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

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
            'first_name' => 'required|min:1|max:120|regex:/^[آ-ی ]+$/u',
            'last_name' => 'required|min:1|max:120|regex:/^[آ-ی ]+$/u',
            'mobile' => 'required|digits:11|unique:users|regex:/^{?(09[0-9]{9,9}}?)$/u',
            'email' => 'required|string|email|unique:users|regex:/^\S+@\S+\.\S+$/u',
            'province' => 'required|numeric|exists:provinces,id',
            'city' => 'required|numeric|exists:cities,id',
            'gender' => 'required|numeric|in:0,1',
            'service_status' => 'sometimes|required|numeric|in:0,1,2',
            'national_code' => ['required', 'digits:10', 'unique:users', 'numeric', new NationalCode()],
            'username' => 'required|unique:users|regex:/^[0-9a-zA-Z]+$/u',
            'password' => ['required', 'unique:users', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
            'avatar' => 'nullable|image|max:800|mimes:png,jpg,jpeg,webp',
            // 'captcha' => ['required','numeric', new NationalCode()],
        ];
    }
}
