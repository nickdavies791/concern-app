<?php

namespace App\Http\Requests;

use App\Tag;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Tag $tag
     * @return bool
     */
    public function authorize(Tag $tag)
    {
        return $this->user()->can('create', $tag);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag' => 'required|max:30|unique:tags,name',
        ];
    }

    /**
     * returns user friendly validation errors
     * @return array
     */
    public function messages(){
        return [
            'tag.required' => 'The tag field is required',
            'tag.max' => 'The tag can only be 30 characters long, please use something shorter.',
            'tag.unique' => 'This tag already exists. Please try something unique.',
        ];
    }
}
