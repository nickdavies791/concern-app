<?php

namespace App\Http\Requests;

use App\Concern;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ConcernRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Concern $concern
     * @return bool
     */
    public function authorize(Concern $concern)
    {
        return $this->user()->can('create', $concern);
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
            'tags.*' => 'required|exists:tags,id',
            'type' => 'required|in:Observation,Disclosure',
            'concern_date' => 'required|date',
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'groups.required' => 'Please select a group to notify about your concern.',
            'groups.exists' => 'The group you have selected no longer exists, please choose another.',
            'students.required' => 'Please select a student which relates to your concern.',
            'students.exists' => 'The student you have selected does not exist on our records.',
            'tags.required' => 'Please select a tag which relates to your concern.',
            'tags.exists' => 'The tag you have selected does not exist on our records.',
            'type.required' => 'Please select whether this concern was an Observation or Disclosure.',
            'type.in' => 'The type you selected was neither Observation or Disclosure.',
            'title.required' => 'Please create an appropriate summary subject. (Do not use sensitive information)',
            'title.max' => 'The summary needs to be shorter, please try again.',
            'concern_date.required' => 'Please select the date you wish to log for this concern.',
            'concern_date.date' => 'The concern date needs to be a date and time.',
        ];
    }
}
