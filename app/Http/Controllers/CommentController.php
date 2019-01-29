<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Concern;
use App\Http\Requests\CommentRequest;

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
        $this->comment->create([
            'user_id' => $request->user_id,
            'concern_id' => $request->concern,
            'body' => $request->body,
            'action_taken' => $request->action_taken
        ]);
        return redirect()->route('concerns.show', ['id' => $request->concern])->with('alert.success', 'Your comment has been saved.');
    }

    /**
     * Display form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $comment = $this->comment->findOrFail($id);

        if (auth()->user()->cannot('update', $comment)) {
            return back()->with('alert.danger', 'You do not have access to edit this comment.');
        }
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource.
     *
     * @param CommentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = $this->comment->findOrFail($id);

        if(auth()->user()->cannot('update', $comment))
        {
            return back()->with('alert.danger', 'You do not have access to edit this comment.');
        }

        $comment->body = $request->body;
        $comment->action_taken = $request->action_taken;
        $comment->save();

        return redirect()->route('concerns.show', ['id' => $comment->concern->id])->with('alert.success', 'Your comment has been updated.');
    }

    /**
     * Soft delete the specified resource.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Comment $comment)
    {
        if (auth()->user()->cannot('delete', $comment)) {
            return redirect()->route('concerns.show', ['id' => $comment->concern->id])->with('alert.danger', 'You do not have access to delete this comment');
        }

        $comment->delete();

        return redirect()->route('concerns.show', ['id' => $comment->concern->id])->with('alert.success', 'The specified comment was deleted');
    }

}
