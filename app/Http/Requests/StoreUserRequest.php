<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'studentname' => ['required', 'string', 'min:2', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mobile' => ['required', 'numeric', 'digits:10'],
            'alternate_mobile' => ['nullable', 'numeric'],
            'gender' => ['required'],
            'dateofbirth' => ['required', 'date'],
            'age' => ['required', 'numeric', 'min:17'],
            'address' => ['required'],
            'pincode' => ['required', 'numeric', 'digits:6'],
            'course' => ['required'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'signatureupload' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
            'terms' => ['accepted'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'studentname.required' => 'Student name is required',
            'studentname.min' => 'Student name must contain at least 2 characters',
            'studentname.regex' => 'Student name should contain only alphabets',
            'email.required' => 'Please enter a valid email address',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'Please enter a valid email address.',
            'mobile.required' => 'Mobile number must contain 10 digits',
            'mobile.numeric' => 'Mobile number must contain 10 digits',
            'mobile.digits' => 'Mobile number must contain 10 digits',
            'alternate_mobile.numeric' => 'Alternate number should contain only numbers',
            'gender.required' => 'Please select gender',
            'dateofbirth.required' => 'Please enter valid date of birth',
            'dateofbirth.date' => 'Please enter valid date of birth',
            'age.required' => 'Student must be at least 17 years old',
            'age.numeric' => 'Student must be at least 17 years old',
            'age.min' => 'Student must be at least 17 years old',
            'address.required' => 'Address field cannot be empty',
            'pincode.required' => 'Pincode must contain 6 digits',
            'pincode.numeric' => 'Pincode must contain 6 digits',
            'pincode.digits' => 'Pincode must contain 6 digits',
            'course.required' => 'Please select a course',
            'percentage.required' => 'Marks must be between 0 and 100',
            'percentage.numeric' => 'The percentage must be a number.',
            'percentage.min' => 'Marks must be between 0 and 100',
            'percentage.max' => 'Marks must be between 0 and 100',
            'signatureupload.required' => 'Please upload valid signature file',
            'signatureupload.file' => 'Please upload valid signature file',
            'signatureupload.mimes' => 'Please upload valid signature file',
            'signatureupload.max' => 'Please upload valid signature file',
            'password.required' => 'Password must contain at least 8 characters',
            'password.min' => 'Password must contain at least 8 characters',
            'password_confirmation.required' => 'Passwords do not match',
            'password_confirmation.same' => 'Passwords do not match',
            'terms.accepted' => 'You must accept terms and conditions',
        ];
    }
}
