<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Subscribe extends FormRequest
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

    public function rules()
    {
        return [
            'website_id' => 'required|integer|exists:websites,id',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
                'website_id' => $this->route('website_id'),
                'user_id' => $this->route('user_id')
            ]
        );
    }
}
