<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeInsertRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            // 'name' => 'required|string|min:3',
            // 'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            // 'password' => 'required|min:6|confirmed',
            // 'employee_designation' => 'required|string|min:2',
            // 'employee_phone_number' => 'required|string:min:11|unique:users,contact_number,NULL,id,deleted_at,NULL',
            // 'employee_department' => 'required|string|min:2',
            // 'employee_image' => 'nullable|image|mimes:jpeg,jpg,bmp,png,gif,svg',

            'first_name'          => 'required|string|min:3',
            'last_name'           => 'required|string|min:3',
            'email'               => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'location'            => 'required',
            'password'            => 'required|min:6|confirmed',
            'status'              => 'required|boolean',
            'designation'         => 'required|string|min:2',
            'contact_number'      => 'required|string:min:11|unique:users,contact_number,NULL,id,deleted_at,NULL',
            'employee_department' => 'required|string|min:2',
            'image'               => 'nullable|image|mimes:jpeg,jpg,bmp,png,gif,svg',
        ];
    }
}
