<?php

namespace App\Http\Controllers;

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
        $concerns = $this->concern->latestUnresolved()->limit(5)->get();
        return view('home', compact('concerns'));
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
