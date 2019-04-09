<?php

namespace App\Http\Controllers;

use App\Concern;
use Illuminate\Http\Request;

class ConcernAttachmentController extends Controller
{
    /**
     * The Concern model instance.
     *
     * @var $concern
     */
    protected $concern;

    /**
     * ConcernAttachmentController constructor.
     * @param Concern $concern
     */
    public function __construct(Concern $concern)
    {
        $this->concern = $concern;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $concern = $this->concern->findorFail($request->concern);

        if (auth()->user()->cannot('update', $concern)) {
			return back()->with('alert.danger', 'You do not have access to edit this concern.');
        }

        return view('attachments.create')->with('concern', $concern);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $concern = $this->concern->findorFail($request->concern);

        if (auth()->user()->cannot('update', $concern)) {
			return back()->with('alert.danger', 'You do not have access to edit this concern.');
        }
        $concern->addAllMediaFromRequest()->each(function ($add) {
            $add->toMediaCollection('attachments');
        });

        return redirect()->route('concerns.show', ['id' => $concern->id]);
    }
}
