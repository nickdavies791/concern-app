<?php

namespace App\Repositories;

use App\Charts\DefaultChart;
use App\Concern;
use App\Tag;
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
        $chart = $this->chart;
        $chart->labels(['A', 'B', 'C']);
        $chart->dataset('Test Dataset', 'bar', [200, 600, 75]);
        return $chart;
    }
}
