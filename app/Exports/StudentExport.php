<?php

namespace App\Exports;

use App\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    /**
     * Return row headings
     * @return array
     */
    public function headings(): array {
        return [
            'MIS ID',
            'Admission Number',
            'UPN',
            'Forename',
            'Surname',
            'Year Group',
            'Birth Date',
            'Ever In Care',
            'SEN Category'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::all('mis_id','admission_number','upn','forename','surname','year_group','birth_date','ever_in_care','sen_category');
    }
}
