<?php

namespace App\Http\Requests;

use App\Concern;
use Illuminate\Foundation\Http\FormRequest;

class ConcernUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Concern $concern
     * @return bool
     */
    public function authorize(Concern $concern)
    {
        return $this->user()->can('update', $concern);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'title.required' => 'Please create an appropriate summary subject. (Do not use sensitive information)',
            'title.max' => 'The summary needs to be shorter, please try again.',
        ];
    }
}
