<?php

namespace App\Http\Requests;


class StoreBlogPost extends CommonRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:50'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name:cannot be empty',
            'name.string' => 'name:must be a string',
            'name.max' => 'name:Maximum length is 50',
        ];
    }
}
