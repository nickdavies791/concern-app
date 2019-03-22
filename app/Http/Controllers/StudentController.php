<?php

namespace App\Http\Controllers;

use App\Student;
use App\Repositories\Chart;
use App\Jobs\GetStudentsFromSims;

class StudentController extends Controller
{
	protected $chart;

	/**
	 * StudentController constructor.
	 * @param Chart $chart
	 */
	public function __construct(Chart $chart)
	{
		$this->chart = $chart;
	}

	/**
	 * Display a listing of the students.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Student $student)
	{
		return $student->select('id', 'mis_id', 'admission_number', 'forename', 'surname', 'year_group')->get();
	}

	/**
	 * Display the specified student.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Student $student)
	{
		return view('students.show')->with([
			'student' => $student->with(['concerns', 'siblings', 'exclusions'])->where('id', $student->id)->first(),
			'attendance' => $this->chart->getStudentAttendance($student->id)
		]);
	}

	/**
	 * Dispatch job to get SIMS data and update student records
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{
		$this->dispatch(new GetStudentsFromSims());

		return redirect('settings')->with('alert.warning', 'The student data is currently syncing.');
	}
}
