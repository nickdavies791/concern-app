<?php

namespace App\Http\Controllers;

use App\Imports\StaffImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StaffImportController extends Controller
{
    /**
     * Import staff members from spreadsheet into DB.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Excel $excel)
    { 
        $excel::import(new StaffImport, $request->file('staff-import'));

        return redirect('settings')->with('alert.success', 'Staff imported successfully!');
    }
}
