<?php

namespace Codeman\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->has('id')){
            return [
               'title'  => 'required',
               'status' => 'required',
               'thumbnail' => 'required',
               'position' => 'required',
               'content' => 'required',
               'category_id' =>'required'
               
               
            ];
        }else{
            return [
               'title'  => 'required',
               'status' => 'required',
               'thumbnail' => 'required',
               'position' => 'required',
               'content' => 'required',
               'category_id' =>'required'
              
            ];
        }
    }
}
