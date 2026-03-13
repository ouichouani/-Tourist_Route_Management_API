<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreitinerarieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'duration_from' => ['required', 'date'], 
            
            'duration_to' => ['required', 'date', 'after_or_equal:duration_from'],
            'image' => ['nullable', 'string', 'max:255'],

            'category_id' => ['nullable', 'exists:categories,id'],    
            'user_id' => ['nullable', 'exists:users,id'],    

            'destinations' => ['required' , 'array'] ,
            'destinations.*' => ['integer', 'exists:destinations,id'] ,

        ];
    }
}
