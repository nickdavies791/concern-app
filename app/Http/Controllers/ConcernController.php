<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Group;
use App\Student;
use App\Http\Requests\ConcernRequest;
use Illuminate\Http\Request;

class ConcernController extends Controller
{
    protected $concern;
    protected $group;
    protected $student;

    /**
     * ConcernController constructor.
     * @param Concern $concern
     * @param Group $group
     * @param Student $student
     */
    public function __construct(Concern $concern, Group $group, Student $student)
    {
        $this->concern = $concern;
        $this->group = $group;
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concerns = $this->concern->with([
            'user:id,name',
            'students:student_id,forename,surname,year_group',
        ])->simplePaginate(5);

        return view('concerns.index', ['concerns' => $concerns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = $this->student->all();
        $groups = $this->group->all();
        return view('concerns.create', ['groups' => $groups, 'students' => $students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConcernRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConcernRequest $request)
    {
        $student = $this->student->find($request->student);
        $concern = $this->concern->create([
            'user_id' => $request->user_id,
            'group_id' => $request->group,
            'title' => $request->title,
        ]);
        $concern->students()->attach($student);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Concern $concern
     * @return void
     */
    public function show(Concern $concern)
    {
        $concern = $this->concern->with([
            'user:id,name',
            'students:student_id,forename,surname,year_group',
            'comments'
        ])->find($concern->id);

        return view('concerns.show', ['concern' => $concern]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO: Create the form for editing concerns
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO: Create the method to update the concern
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Concern $id
     * @return void
     */
    public function destroy(Concern $id)
    {
        $this->concern->destroy($id);
    }
}
