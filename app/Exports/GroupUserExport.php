<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupUserExport implements FromCollection, WithHeadings
{
    /**
     * Return row headings
     * @return array
     */
    public function headings(): array {
        return [
            'ID',
            'Group ID',
            'User ID',
        ];
    }

    /**
     * Return data to export
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('group_user')->get();
    }
}
