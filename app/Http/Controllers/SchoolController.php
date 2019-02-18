<?php

namespace App\Http\Controllers;

use App\Jobs\GetSchoolDetailsFromSims;

class SchoolController extends Controller
{
	/**
	 * Update the specified resource in storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{
		$this->dispatch(new GetSchoolDetailsFromSims());

		return redirect('settings');
	}
}
