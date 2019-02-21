<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Exports\GroupUserExport;
use App\Exports\StaffExport;
use App\Imports\GroupUserImport;
use App\Imports\StaffImport;
use App\Jobs\GetStaffMembersFromSims;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
	protected $user;
	protected $concern;

	/**
	 * UserController constructor.
	 * @param User $user
	 * @param Concern $concern
	 */
	public function __construct(User $user, Concern $concern)
	{
		$this->user = $user;
		$this->concern = $concern;
	}

	/**
	 * Return the concerns related to the authenticated user
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function concerns()
	{
		if (auth()->user()->cannot('view-own', $this->concern)) {
			return redirect('home')->with('alert.danger', 'You do not have access to this page.');
		}
		$concerns = auth()->user()->concerns()->with([
			'user:id,name',
			'students:student_id,forename,surname,year_group',
		])->simplePaginate(5);

		return view('users.concerns')->with('concerns', $concerns);
	}

	/**
	 * Dispatch job to get SIMS data and update staff records
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update()
	{
		$this->dispatch(new GetStaffMembersFromSims());

		return redirect('settings')->with('alert.warning', 'The staff data is currently syncing.');
	}

	/**
	 * Import staff members into the database
	 * @param Request $request
	 * @param Excel $excel
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function import(Request $request, Excel $excel)
	{
		$excel::import(new StaffImport, $request->file('staff-import'));

		return redirect('settings')->with('alert.success', 'Staff imported successfully!');
	}

	/**
	 * Export staff members
	 * @param Excel $excel
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function export(Excel $excel)
	{
		return $excel::download(new StaffExport, 'users.xlsx');
	}

	/**
	 * Export users and groups
	 * @param Excel $excel
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function exportGroups(Excel $excel)
	{
		return $excel::download(new GroupUserExport, 'group_user.xlsx');
	}

	/**
	 * Import staff members into the database
	 * @param Request $request
	 * @param Excel $excel
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function importGroups(Request $request, Excel $excel)
	{
		$excel::import(new GroupUserImport, $request->file('group-user-import'));

		return redirect('settings')->with('alert.success', 'Users assigned to groups successfully!');
	}
}
