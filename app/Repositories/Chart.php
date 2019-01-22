<?php

namespace App\Repositories;

use App\Charts\ConcernsByMonthBreakdown;
use App\Charts\TotalConcernsByTag;
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
     * @return TotalConcernsByTag
     */
    public function totalConcernsByTag()
    {
        $tags = $this->tag->withCount('concerns')->get()->mapWithKeys(function ($item) {
                return [$item->name => $item->concerns_count];
            });;
        $chart = new TotalConcernsByTag;
        $chart->labels($tags->keys()->all());
        $chart->dataset('Number of Concerns', 'bar', $tags->values()->all())->options([
            'backgroundColor' => ['#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89', '#2dce89'],
            'borderWidth' => 1,
        ]);
        return $chart;
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
            ->select(DB::raw('MONTHNAME(created_at) as month, YEAR(created_at) as year, count(*) as total'))
            ->whereBetween('created_at', [$startThisYear, $endThisYear])
            ->where('deleted_at', null)
            ->groupBy('month')->groupBy('year')
            ->orderBy('year', 'asc')->orderByRaw("MONTH(STR_TO_DATE(CONCAT('1 ', month, ' ', year), '%e %M %y')) asc")
            ->get()->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // Query the database and return the total concerns by month between $start and $end
        $concernsLastYear = DB::table('concerns')
            ->select(DB::raw('MONTHNAME(created_at) as month, YEAR(created_at) as year, count(*) as total'))
            ->whereBetween('created_at', [$startLastYear, $endLastYear])
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
