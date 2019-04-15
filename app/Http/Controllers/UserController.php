<?php

namespace App\Http\Controllers;

use App\Jobs\GetStaffMembers;

class UserController extends Controller
{
	/**
	 * Dispatch job to get SIMS data and update staff records
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update()
	{
		dispatch(new GetStaffMembers());

		return redirect('settings')->with('alert.warning', 'The staff data is currently syncing.');
	}
}
