<?php

namespace App\Repositories;

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
     * Return the chart data for total concerns by tag
     * @return array
     */
    public function totalConcernsByTag()
    {
        $tags = $this->tag->withCount('concerns')->get()->mapWithKeys(function ($item) {
                return [$item->name => $item->concerns_count];
            });;
        $chart = [
            'labels' => $tags->keys()->all(),
            'dataset' => $tags->values()->all()
        ];
        return json_encode($chart);
    }

    /**
     * Return the chart data for concerns by month breakdown
     * @return ConcernsByMonthBreakdown
     */
    public function concernsByMonthBreakdown()
    {
        // Set the start and end date
        $startThisYear = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
        $endThisYear = Carbon::now();
        // Set start and end previous year
        $startLastYear = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->subYear()->year, 9, 1);
        $endLastYear = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
        // Set years
        $thisYear = $startThisYear->format('Y').'-'.$endThisYear->format('Y');
        $lastYear = $startLastYear->format('Y').'-'.$endLastYear->format('Y');
        // Query the database and return the total concerns by month between $start and $end
        $concernsThisYear = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(concern_date) as month, YEAR(concern_date) as year, count(*) as total'))
            ->whereBetween('concern_date', [$startThisYear, $endThisYear])
            ->where('deleted_at', null)
            ->groupBy('month')->groupBy('year')
            ->orderBy('year', 'asc')->orderByRaw("MONTH(STR_TO_DATE(CONCAT('1 ', month, ' ', year), '%e %M %y')) asc")
            ->get()->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // Query the database and return the total concerns by month between $start and $end
        $concernsLastYear = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(concern_date) as month, YEAR(concern_date) as year, count(*) as total'))
            ->whereBetween('concern_date', [$startLastYear, $endLastYear])
            ->where('deleted_at', null)
            ->groupBy('month')->groupBy('year')
            ->orderBy('year', 'asc')->orderByRaw("MONTH(STR_TO_DATE(CONCAT('1 ', month, ' ', year), '%e %M %y')) asc")
            ->get()->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // Instantiate the chart and pass the key and values
        $chart = new ConcernsByMonthBreakdown;
        $chart->labels($concernsThisYear->keys()->all());
        $chart->dataset($thisYear, 'line', $concernsThisYear->values()->all())->options([
            'backgroundColor' => '#f5365c',
            'borderColor' => '#f5365c',
            'borderWidth' => 4,
            'fill' => false,
        ]);
        $chart->dataset($lastYear, 'line', $concernsLastYear->values()->all())->options([
            'backgroundColor' => '#5e72e4',
            'borderColor' => '#5e72e4',
            'borderWidth' => 4,
            'fill' => false,
        ]);
        return $chart;
    }
}
