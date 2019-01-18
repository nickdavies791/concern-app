<?php

namespace App\Http\Controllers;

use App\Repositories\Chart;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $chart;

    /**
     * ReportController constructor.
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
        $concernsByMonthBreakdown = $this->chart->concernsByMonthBreakdown();
        $totalConcernsByTag = $this->chart->totalConcernsByTag();
        return view('reports.index', compact('concernsByMonthBreakdown', 'totalConcernsByTag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
