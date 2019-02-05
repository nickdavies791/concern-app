<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GroupUserImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        DB::table('group_user')->truncate();
        foreach ($collection as $row) {
            DB::table('group_user')->insert([
                'group_id' => $row['group_id'],
                'user_id' => $row['user_id'],
            ]);
        }
    }
}
