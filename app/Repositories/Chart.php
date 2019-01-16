<?php

namespace App\Repositories;

use App\Charts\DefaultChart;
use App\Concern;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Chart
{
    protected $chart;
    protected $tag;
    protected $concern;

    /**
     * Chart constructor.
     * @param DefaultChart $chart
     * @param Tag $tag
     * @param Concern $concern
     */
    public function __construct(DefaultChart $chart, Tag $tag, Concern $concern)
    {
        $this->chart = $chart;
        $this->tag = $tag;
        $this->concern = $concern;
    }

    public function testChart()
    {
        $start = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
        $end = Carbon::now();
        $users = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(created_at) as month'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->get();
        dd($users);

        $chart = $this->chart;
        $chart->labels(['A', 'B', 'C']);
        $chart->dataset('Test Dataset', 'bar', [200, 600, 75]);
        return $chart;
    }
}
