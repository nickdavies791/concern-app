<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Syncs Sims data with database records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Student $student)
    {
        $students = (new Student())->getSimsData();
        foreach ($students as $data) {
            try {
                $student->updateOrCreate(['admission_number' => $data->admission_number],[
                    'admission_number' => $data->admission_number,
                    'upn' => $data->upn,
                    'forename' => $data->forename,
                    'surname' => $data->surname,
                    'year_group' => $data->year_group,
                    'birth_date' => $data->birth_date
                ]);
            } catch (\Exception $e) {
                info(['student not added' => ['data' => $student, 'error' => $e]]);
            }
        }

        alert()->success('Success!', 'The students data has been updated correctly');
        return redirect('settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
