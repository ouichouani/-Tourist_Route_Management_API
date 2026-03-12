<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoredistinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'accommodation' => ['required', 'string', 'max:255'],

            'dishes' => ['required', 'array'],
            'dishes.*' => ['integer', 'exists:dishes,id'],

            'places' => ['required', 'array'],
            'places.*' => ['integer', 'exists:places,id'],

            'activities' => ['required', 'array'],
            'activities.*' => ['integer', 'exists:activities,id'],

        ];
    }
}
