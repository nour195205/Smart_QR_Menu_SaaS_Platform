<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:categories,id'],
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'price'        => ['required', 'numeric', 'min:0'],
            'is_available' => ['boolean'],
            'tags'         => ['nullable', 'string'], // Sent as comma-separated string from frontend
            'image'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_image' => ['boolean'], // Flag to delete existing image
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('is_available')) {
            $this->merge([
                'is_available' => filter_var($this->is_available, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if ($this->has('remove_image')) {
            $this->merge([
                'remove_image' => filter_var($this->remove_image, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
