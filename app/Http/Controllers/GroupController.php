<?php

namespace App\Http\Controllers;

use App\Group;

class GroupController extends Controller
{
	/**
	 * Returns groups
	 * @return \Illuminate\Http\Response
	 */
	public function index(Group $group)
	{
		if (auth()->user()->isStaff()) {
			return $group->where('name', 'Safeguarding')->get();
		}

		return $group->all();
	}
}
