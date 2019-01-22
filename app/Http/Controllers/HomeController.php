<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Repositories\Chart;

class HomeController extends Controller
{
    protected $concern;
    protected $chart;

    /**
     * HomeController constructor.
     * @param Concern $concern
     * @param Chart $chart
     */
    public function __construct(Concern $concern, Chart $chart)
    {
        $this->concern = $concern;
        $this->chart = $chart;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concernsByMonthBreakdown = $this->chart->concernsByMonthBreakdown();
        $totalConcernsByTag = $this->chart->totalConcernsByTag();
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home')->with([
            'concernsByMonthBreakdown' => $concernsByMonthBreakdown,
            'totalConcernsByTag' => $totalConcernsByTag,
            'concerns' => $concerns
        ]);
    }

    /**
     * Settings view
     *
     * @return resource
     */
    public function settings()
    {
        return view('settings');
    }
}
