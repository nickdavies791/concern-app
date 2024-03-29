<?php

namespace App\Http\Requests;

use App\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Comment $comment
     * @return bool
     */
    public function authorize(Comment $comment)
    {
        return $this->user()->can('create', $comment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'concern' => 'required|exists:concerns,id',
            'body' => 'required',
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'concern.required' => 'Please select a concern which relates to your comment.',
            'concern.exists' => 'The concern you have selected does not exist anymore.',
            'body.required' => 'Please add a comment in the comment box.',
        ];
    }
}
