<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrStyleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dot_style'           => ['required', 'string', 'max:50'],
            'corner_square_style' => ['required', 'string', 'max:50'],
            'corner_dot_style'    => ['required', 'string', 'max:50'],
            'dot_color'           => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_color'    => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'gradient_enabled'    => ['boolean'],
            'gradient_color_1'    => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'gradient_color_2'    => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'gradient_type'       => ['nullable', 'in:linear,radial'],
            'logo'                => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_logo'         => ['boolean'],
            'frame_style'         => ['nullable', 'string', 'max:50'],
            'top_text'            => ['nullable', 'string', 'max:255'],
            'bottom_text'         => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('gradient_enabled')) {
            $this->merge([
                'gradient_enabled' => filter_var($this->gradient_enabled, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
        if ($this->has('remove_logo')) {
            $this->merge([
                'remove_logo' => filter_var($this->remove_logo, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
