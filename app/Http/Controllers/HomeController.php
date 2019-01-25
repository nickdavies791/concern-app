<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Repositories\Chart;
use App\Student;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

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
     * Perform the search
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $results = (new Search())
            ->registerModel(Student::class, ['forename', 'surname'])
            ->registerModel(Concern::class, 'title')
            ->search($request->input('query'));

        return view('search')->with(['results' => $results]);
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
