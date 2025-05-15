<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'full_name' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'id_number' => 'required|string|max:100',
            'current_address' => 'required|string|max:500',
            'occupants' => 'nullable|string|max:255',
            'pets' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'employment_start' => 'nullable|date',
            'monthly_income' => 'nullable|numeric',
            'employer_contact' => 'nullable|string|max:255',
            'landlord_name' => 'nullable|string|max:255',
            'landlord_contact' => 'nullable|string|max:255',
            'rent_amount' => 'nullable|numeric',
            'reason_leaving' => 'nullable|string|max:500',
            'agree' => 'required|boolean|accepted',

            'id_copy' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'payslip' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'residence_proof' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],

        ];
    }
}
