<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'company' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_address' => 'sometimes|email:rfc|max:50',
            'job_title' => 'sometimes|string|max:50',
            'business_phone' => 'sometimes|string|max:25',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string|max:50',
            'zip_postal_code' => 'sometimes|string|max:15',
            'country_region' => 'sometimes|string|max:50',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company.required' => 'Company is required',
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
        ];
    }
}
