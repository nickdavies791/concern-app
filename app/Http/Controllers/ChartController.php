<?php

namespace App\Http\Controllers;

use App\Repositories\Chart;

class ChartController extends Controller
{
	protected $chart;

	/**
	 * ChartController constructor.
	 * @param Chart $chart
	 */
	public function __construct(Chart $chart)
	{
		$this->chart = $chart;
	}

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$totalConcernsByTag = $this->chart->totalConcernsByTag();
		$concernsThisYear = $this->chart->concernsByMonthBreakdown();

		return view('charts.index')->with([
			'totalConcernsByTag' => $totalConcernsByTag,
			'concernsThisYear'   => $concernsThisYear,
		]);
	}
}
