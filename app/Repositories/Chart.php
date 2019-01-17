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

    /**
     * Return the chart data for concerns by month breakdown
     * @return DefaultChart
     */
    public function concernsByMonthBreakdown()
    {
        // Set the start and end date
        $start = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
        $end = Carbon::now();
        // Query the database and return the total concerns by month between $start and $end
        $users = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(created_at) as month, YEAR(created_at) as year, count(*) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->where('deleted_at', null)
            ->groupBy('month')->groupBy('year')
            ->orderBy('year', 'asc')->orderByRaw("MONTH(STR_TO_DATE(CONCAT('1 ', month, ' ', year), '%e %M %y')) asc")
            ->get()->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // Instantiate the chart and pass the key and values
        $chart = $this->chart;
        $chart->labels($users->keys()->all());
        $chart->dataset('2018-2019', 'line', $users->values()->all())->options([
            'backgroundColor' => '#5e72e4',
            'borderColor' => '#5e72e4',
            'borderWidth' => 5,
            'fill' => false,
        ]);
        return $chart;
    }
}
