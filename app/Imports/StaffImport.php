<?php

namespace App\Imports;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
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
}
