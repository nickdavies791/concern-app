<?php

namespace App\Http\Controllers;

use App\Jobs\GetSchoolDetailsFromSims;

class SchoolController extends Controller
{
	/**
	 * get the schools details from Assembly API.
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{
		$this->dispatch(new GetSchoolDetailsFromSims());

		return redirect('settings');
	}
}
