<?php

namespace App\Http\Requests\User\Profile;

use App\Rules\NationalCode;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'mobile' => ['required','digits:11','regex:/^{?(09[0-9]{9,9}}?)$/u', Rule::unique('users')->ignore($this->user()->mobile, 'mobile')],
            'email' => ['required','string','email','regex:/^\S+@\S+\.\S+$/u', Rule::unique('users')->ignore($this->user()->email, 'email')],
            'province' => 'required|numeric|exists:provinces,id',
            'city' => 'required|numeric|exists:cities,id',
            'national_code' => ['required', 'digits:10', 'numeric', new NationalCode(), Rule::unique('users')->ignore($this->user()->national_code, 'national_code')],
            'avatar' => 'nullable|image|max:800|mimes:png,jpg,jpeg,webp',
        ];
    }
}
