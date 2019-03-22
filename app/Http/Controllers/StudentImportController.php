<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportController extends Controller
{
    /**
    * Import students into the database
    * @param Request $request
    * @param Excel $excel
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(Request $request, Excel $excel)
    {
        $excel::import(new StudentImport, $request->file('student-import'));

        return redirect('settings')->with('alert.success', 'Students imported successfully!');
    }
}
