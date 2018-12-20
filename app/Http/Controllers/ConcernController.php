<?php

namespace App\Http\Controllers;

use App\Group;
use App\Student;
use App\Concern;
use App\Repositories\Image;
use App\Events\ConcernCreated;
use App\Http\Requests\ConcernRequest;

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
        if (auth()->user()->cannot('create', $this->concern)) {
            return redirect('home')->with('alert.danger', 'You do not have access to this page.');
        }

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
        if (auth()->user()->cannot('create', $this->concern)) {
            return redirect('home')->with('alert.danger', 'You do not have access to this page.');
        }

        $concern = $this->concern->create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'body' => $request->body,
            'concern_date' => $request->concern_date,
        ]);

        if($request->image){
            $location = $this->image->location('concerns/'.$concern->id);
            $this->image->save($request->image, $location, date('Y-m-d_His').'_bodymap.png');

            $concern->attachments()->create([
                'concern_id' => $concern->id,
                'file_name' => $location.'/'.date('Y-m-d_His').'_bodymap.png',
            ]);
        }

        //sorts relationships and notifies selected groups
        event(new ConcernCreated($concern, $request));

        return redirect()
        ->route('concerns.show', ['id' => $concern->id])
        ->with('alert.success', 'Your concern has been saved and a notification has been sent.');
    }

    /**
     * Display the specified resource.
     *
     * @param Concern $concern
     * @return void
     */
    public function show(Concern $concern)
    {
        if (auth()->user()->cannot('view', $concern)) {
            return back()->with('alert.danger', 'You do not have access to view this concern.');
        }

        $concern = $this->concern->with([
            'user:id,name',
            'students:student_id,forename,surname,year_group',
            'attachments',
            'comments' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->find($concern->id);

        return view('concerns.show', ['concern' => $concern]);
    }


    public function edit($id)
    {
        // TODO: Create the form for editing concerns
    }


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
        if (auth()->user()->cannot('delete', $this->concern)) {
            return redirect('home')->with('alert.danger', 'You do not have access to this page.');
        }

        $this->concern->destroy($id);
    }
}
