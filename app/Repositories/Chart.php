<?php

namespace App\Repositories;

use App\Charts\ConcernsByMonthBreakdown;
use App\Concern;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Chart
{
    protected $tag;
    protected $concern;

    /**
     * Chart constructor.
     * @param Tag $tag
     * @param Concern $concern
     */
    public function __construct(Tag $tag, Concern $concern)
    {
        $this->tag = $tag;
        $this->concern = $concern;
    }

    /**
     * Return the chart data for concerns by month breakdown
     * @return ConcernsByMonthBreakdown
     */
    public function concernsByMonthBreakdown()
    {
        // Set the start and end date
        $start = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
        $end = Carbon::now();
        $year = $start->format('Y').'-'.$end->format('Y');
        // Query the database and return the total concerns by month between $start and $end
        $concerns = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(created_at) as month, YEAR(created_at) as year, count(*) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->where('deleted_at', null)
            ->groupBy('month')->groupBy('year')
            ->orderBy('year', 'asc')->orderByRaw("MONTH(STR_TO_DATE(CONCAT('1 ', month, ' ', year), '%e %M %y')) asc")
            ->get()->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // Instantiate the chart and pass the key and values
        $chart = new ConcernsByMonthBreakdown;
        $chart->labels($concerns->keys()->all());
        $chart->dataset($year, 'line', $concerns->values()->all())->options([
            'backgroundColor' => '#5e72e4',
            'borderColor' => '#5e72e4',
            'borderWidth' => 4,
            'fill' => false,
        ]);
        return $chart;
    }
}
