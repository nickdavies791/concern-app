<?php

namespace App\Imports;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StaffImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Update the User with new data
     * @param array $row
     * @return void
     */
    public function model(array $row)
    {
        User::updateOrCreate(['staff_code' => $row['staff_code']], [
            'role_id' => $row['role_id'],
            'staff_code' => $row['staff_code'],
            'name' => $row['name'],
            'email' => $row['email'],
            'imported_at' => Carbon::now(),
            'password' => Hash::make($row['password'])
        ]);
    }

    /**
     * Validate the data
     * @return array
     */
    public function rules(): array {
        return [
            'role_id' => 'required|exists:roles,id',
            'staff_code' => 'required',
            'name' => 'required|max:255',
            'email' => 'email',
        ];
    }

    /**
     * Provide custom validation messages
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'role_id.required' => 'The role ID is required.',
            'role_id.exists' => 'The role ID provided does not exist.',
            'staff_code.required' => 'The staff code is required.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field exceeds the maximum length of 255.',
            'email.email' => 'Please provide an email address.',
        ];
    }
}
