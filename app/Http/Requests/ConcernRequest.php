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
            'group' => 'required|exists:groups,id',
            'student' => 'required|exists:students,id',
            'title' => 'required|max:100',
        ];
    }
}
