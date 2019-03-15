<?php

namespace App\Http\Controllers;

use App\Imports\TagImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TagImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.import');
    }

    /**
	 * Import tags into the database
	 * @param Request $request
	 * @param Excel $excel
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request, Excel $excel)
    {
        $excel::import(new TagImport, $request->file('tag-import'));
        return redirect('settings')->with('alert.success', 'Tags imported successfully!');
    }

}
