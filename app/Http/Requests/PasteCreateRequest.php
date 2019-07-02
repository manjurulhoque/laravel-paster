<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasteCreateRequest extends FormRequest
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
            'contents' => 'required|min:1',
            'status'  => 'required|numeric|in:1,2,3',
            'syntax'  => 'required|exists:syntaxes,slug',
            'expire'  => 'required|max:3|in:N,10M,1H,1D,1W,2W,1M,6M,1Y,SD',
            'title'   => 'nullable|max:80|clean_string',
            'password'=> 'nullable|max:50|string',
        ];
    }

    /**
     * The controller action to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectAction = 'Frontend\HomeController@index';
}
