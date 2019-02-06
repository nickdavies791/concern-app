<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Student;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

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
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home')->with([
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
