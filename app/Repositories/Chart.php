<?php

namespace App\Repositories;

use App\Attendance;
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
	 * Return the chart data for student attendance
	 * @param int $id
	 * @return false|string
	 */
	public function getStudentAttendance(int $id)
	{
		$attendance = Attendance::select(
			'possible_sessions', 'attended_sessions', 'late_sessions', 'authorised_absence_sessions', 'unauthorised_absence_sessions'
		)->where('student_id', $id)->first()->toArray();
		$chart = [
			'labels'   => [
				'Possible Sessions - ' . $attendance['possible_sessions'],
				'Attended Sessions - ' . $attendance['attended_sessions'],
				'Late Sessions - ' . $attendance['late_sessions'],
				'Authorised Absences - ' . $attendance['authorised_absence_sessions'],
				'Unauthorised Absences - ' . $attendance['unauthorised_absence_sessions'],
			],
			'datasets' => [
				[
					'data'            => array_values($attendance),
					'backgroundColor' => [
						'#36a2eb',
						'#4bc0c0',
						'#ff9f40',
						'#ffcd56',
						'#ff6384',
					]
				]
			]
		];

		return json_encode($chart);
	}

	/**
	 * Return the chart data for total concerns by tag
	 * @return array
	 */
	public function totalConcernsByTag()
	{
		$tags = $this->tag->withCount('concerns')->get()->mapWithKeys(function ($item) {
			return [$item->name => $item->concerns_count];
		});
		$chart = [
			'labels'   => $tags->keys()->all(),
			'datasets' => [
				[
					'label' => '# of Concerns',
					'data'  => $tags->values()->all()
				]
			]
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
		// Set years
		$thisYear = $startThisYear->format('Y') . '-' . $endThisYear->format('Y');
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

		$chart = [
			'labels'   => $concernsThisYear->keys()->all(),
			'datasets' => [
				[
					'label' => $thisYear,
					'data'  => $concernsThisYear->values()->all(),
				],
			]
		];

		return json_encode($chart);
	}
}
