<?php

namespace App\Http\Controllers;

use App\Exports\TagExport;
use App\Imports\TagImport;
use App\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TagController extends Controller
{
    protected $tag;

    /**
     * TagController constructor.
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tag->select('id', 'name')->get();
    }

    /**
     * Import tags into the database
     * @param Request $request
     * @param Excel $excel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request, Excel $excel)
    {
        $excel::import(new TagImport, $request->file('tag-import'));
        return redirect('settings')->with('alert.success', 'Tags imported successfully!');
    }

    /**
     * Export tags
     * @param Excel $excel
     * @return mixed
     */
    public function export(Excel $excel)
    {
        return $excel::download(new TagExport, 'tags.xlsx');
    }
}
