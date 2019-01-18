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
        $chart = $this->chart->concernsByMonthBreakdown();
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home')->with(['concerns' => $concerns, 'chart' => $chart]);
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
