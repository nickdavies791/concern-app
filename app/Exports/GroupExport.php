<?php

namespace App\Exports;

use App\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupExport implements FromCollection, WithHeadings
{
    /**
     * Return row headings
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name'
        ];
    }

    /**
     * Return data to export
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Group::all();
    }
}
