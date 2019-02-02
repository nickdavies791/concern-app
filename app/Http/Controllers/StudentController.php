<?php

namespace App\Http\Controllers;

use App\Jobs\GetStudentsFromSims;
use App\Repositories\Assembly;
use App\Student;

class StudentController extends Controller
{
    protected $student;

    /**
     * StudentController constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->student->select('id', 'forename', 'surname')->get();
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->student->where('id', '=', $id)->with(['concerns','siblings'])->first();
        return view('students.show', ['student' => $student]);
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
