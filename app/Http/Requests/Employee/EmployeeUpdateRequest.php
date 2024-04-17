<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest {
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
            'id'                  => 'required|exists:users,id,deleted_at,NULL',
            'email'               => 'required|email|unique:users,email,' . $this->id . ',id,deleted_at,NULL',
            'location'            => 'required',
            'first_name'          => 'required|string|min:3',
            'last_name'           => 'required|string|min:3',
            'password'            => 'nullable|min:6|confirmed',
            'status'              => 'required|boolean',
            'designation'         => 'required|string|min:2',
            'employee_department' => 'required|string|min:2',
            'contact_number'      => 'required|string:min:11|unique:users,contact_number,' . $this->id . ',id,deleted_at,NULL',
            'image'               => 'nullable|image|mimes:jpeg,jpg,bmp,png,gif,svg',

        ];
    }
}
