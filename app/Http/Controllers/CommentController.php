<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Concern;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected $comment;
    protected $concern;

    /**
     * CommentController constructor.
     * @param Comment $comment
     * @param Concern $concern
     */
    public function __construct(Comment $comment, Concern $concern)
    {
        $this->comment = $comment;
        $this->concern = $concern;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $concerns = $this->concern->all();
        return view('comments.create', ['concerns' => $concerns]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $this->comment->create([
            'user_id' => $request->user_id,
            'concern_id' => $request->concern,
            'body' => $request->body,
            'action_taken' => $request->action_taken
        ]);
        return back();
    }

}
