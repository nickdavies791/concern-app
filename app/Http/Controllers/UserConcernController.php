<?php

namespace App\Http\Controllers;

use App\Concern;

class UserConcernController extends Controller
{
	/**
	 * Return the concerns related to the authenticated user
	 * @param Concern $concern
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function index(Concern $concern)
	{
		if (auth()->user()->cannot('view-own', $concern)) {
			return redirect('home')->with('alert.danger', 'You do not have access to this page');
		}

		$concerns = auth()->user()->concerns()->with([
			'user:id,name',
			'students:student_id,forename,surname,year_group'
		])->simplePaginate(5);

		return view('users.concerns')->with('concerns', $concerns);
	}
}
