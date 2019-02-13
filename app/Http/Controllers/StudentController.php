<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Jobs\GetStudentsFromSims;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        return $this->student->select('id', 'mis_id', 'admission_number', 'forename', 'surname', 'year_group')->get();
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

    /**
     * Import students into the database
     * @param Request $request
     * @param Excel $excel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request, Excel $excel)
    {
        $excel::import(new StudentImport, $request->file('student-import'));
        return redirect('settings')->with('alert.success', 'Students imported successfully!');
    }

    /**
     * Export students
     * @param Excel $excel
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Excel $excel)
    {
        return $excel::download(new StudentExport, 'students.xlsx');
    }

}
