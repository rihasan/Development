<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IntegerArray;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:256',
            'body' => ['required', 'string'],
            'user_ids' => [
            'array',
            'required',

            new IntegerArray(),

            // function ($attributes, $value, $fail){
            //     $integerOnly = collect($value)->every(fn ($element) => is_int($element));
            //     if (!$integerOnly) {
            //         $fail($attributes. ' can only be integer.');
            //         }
            //     }
            
            ],

        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'Please insert a valid body for the post.',
        ];
    }
}
