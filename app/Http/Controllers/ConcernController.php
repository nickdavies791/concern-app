<?php

namespace App\Http\Controllers;

use App\Group;
use App\Repositories\Image;
use App\Student;
use App\Concern;
use Illuminate\Http\Request;
use App\Http\Requests\ConcernRequest;
use Illuminate\Support\Facades\Storage;

class ConcernController extends Controller
{
    protected $concern;
    protected $group;
    protected $student;
    protected $image;

    /**
     * ConcernController constructor.
     * @param Concern $concern
     * @param Group $group
     * @param Student $student
     * @param Image $image
     */
    public function __construct(Concern $concern, Group $group, Student $student, Image $image)
    {
        $this->concern = $concern;
        $this->group = $group;
        $this->student = $student;
        $this->image = $image;
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
        return view('concerns.create', [
            'groups' => $this->group->all(),
            'students' => $this->student->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConcernRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConcernRequest $request)
    {
        $concern = $this->concern->create([
            'user_id' => $request->user_id,
            'group_id' => $request->group,
            'title' => $request->title,
            'body' => $request->body,
            'concern_date' => $request->concern_date,
        ]);

        $location = $this->image->location('concerns/'.$concern->id);
        $this->image->save($request->image, $location, date('Y-m-d_his').'_bodymap.png');

        $concern->students()->attach(
            $this->student->find($request->student)
        );

        return redirect()->route('concerns.show', ['id' => $concern->id])->with('alert.success', 'Your concern has been saved and a notification has been sent.');
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
            'comments' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
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
