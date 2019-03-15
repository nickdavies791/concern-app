<?php

namespace App\Http\Controllers;

use App\Exports\TagExport;
use Maatwebsite\Excel\Facades\Excel;

class TagExportController extends Controller
{
    /**
    * Export tags
    * @param Excel $excel
    * @return mixed
    */
    public function index(Excel $excel)
    {
        return $excel::download(new TagExport, 'tags.xlsx');
    }
}
