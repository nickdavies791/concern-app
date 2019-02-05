<?php

namespace App\Imports;

use App\Group;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GroupImport implements ToModel, WithHeadingRow
{
    /**
     * Update the Group with new data
     * @param array $row
     * @return void
     */
    public function model(array $row)
    {
        Group::updateOrCreate(['id' => $row['id']], [
            'name' => $row['name']
        ]);
    }

    /**
     * Validate the data
     * @return array
     */
    public function rules(): array {
        return [
            'name' => 'required|max:255'
        ];
    }

    /**
     * Provide custom validation messages
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field exceeds the maximum length of 255.',
        ];
    }
}
