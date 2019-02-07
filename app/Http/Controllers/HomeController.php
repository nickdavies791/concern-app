<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Repositories\Chart;
use App\Student;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class HomeController extends Controller
{
    protected $chart;
    protected $concern;

    /**
     * HomeController constructor.
     * @param Chart $chart
     * @param Concern $concern
     */
    public function __construct(Chart $chart, Concern $concern)
    {
        $this->chart = $chart;
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
        $totalConcernsByTag = $this->chart->totalConcernsByTag();
        $concernsThisYear = $this->chart->concernsByMonthBreakdown();
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home')->with([
            'totalConcernsByTag' => $totalConcernsByTag,
            'concernsThisYear' => $concernsThisYear,
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
