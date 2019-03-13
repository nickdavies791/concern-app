<?php

namespace App\Http\Controllers;

use App\Exports\GroupExport;
use Maatwebsite\Excel\Facades\Excel;

class GroupExportController extends Controller
{
    /**
     * Exports the groups from the app into a spreadsheet.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Excel $excel)
    {
        return $excel::download(new GroupExport, 'groups.xlsx');
    }
}
