<?php

namespace Codeman\Admin\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContactUsRequest
 *
 * @package \Codeman\Admin\Http\Requests
 */
class ApplicationRequest extends FormRequest
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
            'name' => 'string|required',
            'surname' => 'string|required',
            'email' => 'required|email',
            'phone' => 'string|required',
            'comments' =>'string|required'
        ];
    }
}
