<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreatePost extends FormRequest
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
            'website_id' => 'required|integer|exists:websites,id',
            'title' => 'required|string|max:120',
            'content' => 'string|max:1600',
            'status' => 'required|in:1,2',
            'slug' => 'required|string|max:120'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
                'website_id' => $this->route('website_id'),
                'slug' => Str::snake($this->title)
            ]
        );
    }
}
