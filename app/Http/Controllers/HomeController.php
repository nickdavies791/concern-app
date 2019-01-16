<?php

namespace App\Http\Controllers;

use App\Charts\TestChart;
use App\Concern;

class HomeController extends Controller
{
    protected $concern;

    /**
     * HomeController constructor.
     * @param Concern $concern
     */
    public function __construct(Concern $concern)
    {
        $this->concern = $concern;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart = new TestChart;
        $chart->labels(['A', 'B', 'C']);
        $chart->dataset('Test Dataset', 'line', [1, 2, 3]);
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home', compact('concerns', 'chart'));
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
