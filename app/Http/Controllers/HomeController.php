<?php

namespace App\Http\Controllers;

use App\School;
use App\Student;
use App\Concern;
use App\Repositories\Chart;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class HomeController extends Controller
{
	/**
	 * Chart object
	 * @var App\Repositories\Chart
	 */
	protected $chart;

	/**
	 * Concern Model
	 * @var App\Concern
	 */
	protected $concern;

	/**
	 * School Model
	 * @var App\School
	 */
	protected $school;

	/**
	 * HomeController constructor.
	 * @param Chart $chart
	 * @param Concern $concern
	 * @param School $school
	 */
	public function __construct(Chart $chart, Concern $concern, School $school)
	{
		$this->chart = $chart;
		$this->concern = $concern;
		$this->school = $school;
	}

	/**
	 * Show the application dashboard.
	 */
	public function index()
	{
		return view('home')->with([
			'school'             => $this->school->first(),
			'totalConcernsByTag' => $this->chart->totalConcernsByTag(),
			'concernsThisYear'   => $this->chart->concernsByMonthBreakdown(),
			'concerns'           => $this->concern->latestUnresolved()->limit(5)->get()
		]);
	}

	/**
	 * Perform the search
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search(Request $request)
	{
		$results = (new Search())
			->registerModel(Student::class, ['forename', 'surname'])
			->registerModel(Concern::class, 'type')
			->search($request->input('query'));

		return view('search')->with(['results' => $results]);
	}
}
