<?php

namespace Codeman\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        if($this->get('_method') == 'PUT'){
            return [
                'title'  => 'required',
                'slug'   => 'required|unique:pages,slug,'.$this->get("id"),
                'status' => 'required',
            ];
        }else{
            return [
                'title'  => 'required',
                // 'slug'   => 'required|unique:pages',
                'status' => 'required',
            ];
        };
    }
}
