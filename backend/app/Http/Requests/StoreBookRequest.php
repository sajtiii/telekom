<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // todo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => ['required', 'string', 'min:3', 'max:100'],
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'publish_date' => ['required', 'date'], // NOTE: `publish_date` can be in the future for upcoming books. If not, add `before:now` rule.
            'isbn' => ['required', 'string', 'min:10', 'max:13'], // NOTE: `isbn  should be 13 digit long according to https://www.isbn.org/about_isbn_standard, but json file contains 10 digits only.
            'summary' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'on_store' => ['required', 'integer', 'min:0'],
        ];
    }
}
