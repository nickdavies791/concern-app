<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Comment;
use App\Concern;
use App\Repositories\Image;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    protected $comment;
    protected $concern;
    protected $image;

    /**
     * CommentController constructor.
     * @param Comment $comment
     * @param Concern $concern
     * @param Image $image
     */
    public function __construct(Comment $comment, Concern $concern, Image $image)
    {
        $this->comment = $comment;
        $this->concern = $concern;
        $this->image = $image;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->cannot('create', $this->comment)) {
            return back()->with('alert.danger', 'You do not have access to this page.');
        }
        return view('comments.create', [
            'concerns' => $this->concern->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $concern = $this->concern->find($request->concern);
        if (auth()->user()->cannot('view', $concern)) {
            return back()->with('alert.danger', 'You do not have access to add comments to this concern.');
        }
        $comment = $this->comment->create([
            'user_id' => $request->user_id,
            'concern_id' => $request->concern,
            'body' => $request->body,
            'action_taken' => $request->action_taken
        ]);
        if($request->image){
            $location = $this->image->location('concerns/'.$comment->concern_id);
            $name = date('Y-m-d_His').'_bodymap.png';
            $this->image->save($request->image, $location, $name);
            $attachment = new Attachment;
            $attachment->create([
                'concern_id' => $comment->concern_id,
                'file_name' => $location.'/'.$name,
            ]);
        }
        return redirect()->route('concerns.show', ['id' => $request->concern])->with('alert.success', 'Your comment has been saved.');
    }

}
