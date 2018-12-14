<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: needs policies setting up
        return true;
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
            'action_taken' => 'required',
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
            'action_taken.required' => 'Please enter any action taken, if no action was taken enter "none". '
        ];
    }
}
