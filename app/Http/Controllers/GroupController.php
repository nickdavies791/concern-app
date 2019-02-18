<?php

namespace App\Http\Controllers;

use App\Exports\GroupExport;
use App\Group;
use App\Imports\GroupImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
	protected $group;

	/**
	 * GroupController constructor.
	 * @param Group $group
	 */
	public function __construct(Group $group)
	{
		$this->group = $group;
	}

	/**
	 * Returns groups
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (auth()->user()->isStaff()) {
			return $this->group->where('name', 'Safeguarding')->get();
		}

		return $this->group->all();
	}

	/**
	 * Import groups into the database
	 * @param Request $request
	 * @param Excel $excel
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function import(Request $request, Excel $excel)
	{
		$excel::import(new GroupImport, $request->file('group-import'));

		return redirect('settings')->with([
			'alert.success', 'Groups imported successfully!'
		]);
	}

	/**
	 * Export groups
	 * @param Excel $excel
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function export(Excel $excel)
	{
		return $excel::download(new GroupExport, 'groups.xlsx');
	}
}
