<?php

namespace App\Imports;

use App\Student;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Update the Student with new data
     * @param array $row
     * @return void
     */
    public function model(array $row)
    {
        Student::updateOrCreate(['mis_id' => $row['mis_id']], [
            'admission_number' => $row['admission_number'],
            'upn' => $row['upn'],
            'forename' => $row['forename'],
            'surname' => $row['surname'],
            'year_group' => $row['year_group'],
            'birth_date' => Carbon::parse($row['birth_date'])->format('y-m-d'),
            'ever_in_care' => $row['ever_in_care'],
            'sen_category' => $row['sen_category']
        ]);
    }

    /**
     * Validate the data
     * @return array
     */
    public function rules(): array {
        return [
            'admission_number' => 'numeric|nullable',
            'upn' => 'required|max:13',
            'forename' => 'required|max:255',
            'surname' => 'required|max:255',
            'year_group' => 'required|numeric',
            'birth_date' => 'date|nullable',
            'ever_in_care' => 'numeric|nullable',
            'sen_category' => 'alpha|max:1|nullable',
        ];
    }

    /**
     * Provide custom validation messages
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'admission_number.numeric' => 'Please provide a number for the admission number.',
            'upn.required' => 'The UPN field is required.',
            'upn.max' => 'The UPN field exceeds the maximum length of 255.',
            'forename.required' => 'The forename field is required.',
            'forename.max' => 'The forename field exceeds the maximum length of 255.',
            'surname.required' => 'The surname field is required.',
            'surname.max' => 'The surname field exceeds the maximum length of 255.',
            'year_group.required' => 'The year group field is required.',
            'year_group.numeric' => 'You must provide a valid year group for the student.',
            'birth_date.date' => 'The birth date field provided is not a valid date.',
            'ever_in_care.numeric' => 'The ever_in_care field should be either 1 or 0.',
            'sen_category.alpha' => 'The SEN category field should be a letter.',
            'sen_category.max' => 'The SEN category field exceeds the maximum length of 1.',
        ];
    }
}
