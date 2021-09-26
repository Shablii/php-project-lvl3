<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
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
        return ['url.name' => 'required|max:255|url'];
    }

    public function messages()
    {
        return [
            'url.name.required' => 'Некорректный URL',
            'url.name.max' => 'Некорректный URL',
            'url.name.unique' => 'Имя сайта уже используется',
            'url.name.url' => 'Некорректный URL'
        ];
    }
}
