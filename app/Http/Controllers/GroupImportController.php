<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\GroupImport;
use Maatwebsite\Excel\Facades\Excel;

class GroupImportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Excel $excel)
    {
        $excel::import(new GroupImport, $request->file('group-import'));

        return redirect('settings')->with('alert.success', 'Users assigned to groups successfully!');
    }
}
