<?php

namespace Modules\Catalog\Http\Requests\Tnved;

use Illuminate\Foundation\Http\FormRequest;

class TnvedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title' => 'required',
          'code' => 'required|integer',
          'active' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
