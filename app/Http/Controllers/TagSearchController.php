<?php

namespace App\Http\Controllers;

use App\Tag;

class TagSearchController extends Controller
{
	/**
	* Used to get the tags for the multi-select input 
	* on the front-end TagSelect.vue
	*/
	public function index(Tag $tag)
	{
		return $tag->select('id', 'name')->get();
	}
}
