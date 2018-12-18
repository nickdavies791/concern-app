<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConcernRequest extends FormRequest
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
            'groups.*' => 'required|exists:groups,id',
            'students.*' => 'required|exists:students,id',
            'title' => 'required|max:100',
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'group.required' => 'Please select a group to notify about your concern.',
            'group.exists' => 'The group you have selected no longer exists, please choose another.',
            'student.required' => 'Please select a student which relates to your concern.',
            'student.exists' => 'The student you have selected does not exist on our records.',
            'title.required' => 'Please create an appropriate summary subject.',
            'title.max' => 'The summary needs to be shorter, please try again.',
        ];
    }
}
