<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentExportController extends Controller
{
    /**
	 * Export students
	 * @param Excel $excel
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
    public function index(Excel $excel)
    {
        return $excel::download(new StudentExport, 'students.xlsx');
    }
}
