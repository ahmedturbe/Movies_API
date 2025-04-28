<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'image_id' => 'required|exists:images,id',
            'slug' => 'required|string|max:255|unique:actors,slug',
            'id' => 'required|integer|exists:actors,id',
            'imageable_type' => 'required|string|in:App\Models\Actor',
            'imageable_id' => 'required|integer|exists:actors,id',

        ];
    }
}
