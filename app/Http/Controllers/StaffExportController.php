<?php

namespace App\Http\Controllers;

use App\Exports\StaffExport;
use Maatwebsite\Excel\Facades\Excel;

class StaffExportController extends Controller
{
    /**
     * Returns staff from concern app in a spreadsheet.
     * @return \Illuminate\Http\Response
     */
    public function index(Excel $excel)
    {
        return $excel::download(new StaffExport, 'users.xlsx');
    }
}
