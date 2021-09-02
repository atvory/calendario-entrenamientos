<?php

namespace App\Http\Requests;

use App\Http\Controllers\FastEventRequest;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'La actividad debe tener un título',
            'title.min' => 'El título debe tener un mínimo de 3 caracteres',
        ];
    }
}
