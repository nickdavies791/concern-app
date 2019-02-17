<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Concern;

class StatsWidgetComposer
{
    protected $concerns;

    /**
     * StatsWidgetComposer constructor.
     * @param Concern $concerns
     */
    public function __construct(Concern $concerns)
    {
        $this->concerns = $concerns;
    }

    /**
     * Bind the data to the view
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('countResolvedThisAcademicYear', $this->concerns->resolvedThisAcademicYear()->count());
        $view->with('countResolvedLastMonth', $this->concerns->resolvedLastMonth()->count());
        $view->with('countReportedThisAcademicYear', $this->concerns->reportedThisAcademicYear()->count());
        $view->with('countReportedLastMonth', $this->concerns->reportedLastMonth()->count());
    }
}