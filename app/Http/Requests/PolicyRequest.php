<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyRequest extends FormRequest
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
            'name' => 'required|string|unique:policies,name|max:100',
            'groups' => 'array|required|exists:groups,id',
            'file_path' => 'nullable|file|mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png'
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'name.required' => 'You must give the policy a name',
            'name.unique' => 'Policy already exists within the application',
            'name.max' => 'The policy name is too long',
            'groups.required' => 'Please select at least one group to publish this policy to',
            'groups.exists' => 'The groups you have selected don\'t exist please select another',
            'file_path.file' => 'The object you have uploaded is not a file',
            'file_path.mimes' => 'The file you have uploaded is not supported, check out whats supported in the help section'
        ];
    }
}
