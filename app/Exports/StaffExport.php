<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromCollection, WithHeadings
{
    /**
     * Return row headings
     * @return array
     */
    public function headings(): array {
        return [
            'ID',
            'Role ID',
            'Staff Code',
            'Name',
            'Email',
        ];
    }

    /**
     * Return data to export
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all('id','role_id','staff_code','name','email');
    }
}
