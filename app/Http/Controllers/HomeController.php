<?php

namespace App\Http\Controllers;

use App\Concern;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concern = new Concern;
        $concerns = $concern->latestUnresolved()->limit(5)->get();
        return view('home', compact('concerns'));
    }

    public function settings(){
        return view('settings');
    }
}
