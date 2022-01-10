<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|min:3|unique:categories',
            'description' => ['required', function ($attribute, $value, $fail) {
                if (strlen(strip_tags($value)) < 3) {
                    $fail('The '.$attribute.' must be atleast 3 characters.');
                }
            },]
        ];
    }
}